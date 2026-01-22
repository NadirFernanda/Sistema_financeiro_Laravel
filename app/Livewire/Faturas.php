<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\Factura;
use App\Models\Usuario;
use Livewire\WithFileUploads;

class Faturas extends Component
{


    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        if (!$this->showForm) {
            $this->resetForm();
        }
    }
    public $showForm = false;
    public $observacoes;
    use WithFileUploads;

    public $faturas;
    public $numero_factura;
    public $empresa_nome;
    public $tipo_servico;
    public $natureza;
    public $tipologia;
    public $data_execucao;
    public $data_pagamento;
    public $valor_total;
    public $valor_pago;
    public $arquivo;
    public $status;
    public $fatura_id;
    public $isEdit = false;
    public $successMessage = '';
    public $errorMessage = '';
    public $pesquisa_numero = '';

    protected $rules = [
        'numero_factura' => 'required|string|max:100|unique:facturas,numero_factura',
        'empresa_nome' => 'nullable|string|max:255',
        'tipo_servico' => 'nullable|string|max:255',
        'natureza' => 'required|in:Abono De Família Subsídios Do Pessoal Civil,Aquisição De Mobiliário,Bilhetes De Passagem,Combustíveis E Lubrificantes,Contribuições Do Empregador Para A Segurança Social,Décimo Terceiro Mês Do Pessoal Civil,Encargos Aduaneiros E Portuários,Material De Consumo Corrente Especializado,Materiais E Utensílios Duradouros De Especialidade,Outros Materiais De Consumo Corrente,Outros Materiais E Utensilios Duradouros,Outros Serviços,Rendas De Imoveis,Seguros,Serviço De Protecção E Vigilância,Serviços De Água E Electricidade,Serviços De Ensino E Formação,Serviços De Hospedagem E Alimentação,Serviços De Limpeza E Saneamento,Serviços De Manutenção E Conservação,Serviços De Processamento De Dados,Serviços De Saúde,Serviços De Telecomunicação,Serviços De Transportação De Pessoas E Bens,Subsídios De Deslocação,Víveres E Géneros Alimentícios,Vencimentos De Outro Pessoal Civil',
        'tipologia' => 'required|in:Factura recibo,Proforma,Factura,Recibo,Nota de entrega',
        'data_execucao' => 'nullable|date',
        'data_pagamento' => 'nullable|date',
        'valor_total' => 'nullable|numeric|min:0',
        'valor_pago' => 'nullable|numeric|min:0',
        'arquivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'status' => 'nullable|string|max:50',
    ];

    protected $messages = [
        'numero_factura.required' => 'O número da fatura é obrigatório.',
        'numero_factura.unique' => 'Já existe uma fatura com este número.',
        'numero_factura.max' => 'Número da fatura muito longo.',
        'empresa_nome.max' => 'Nome da empresa muito longo.',
        'tipo_servico.max' => 'Tipo de serviço muito longo.',
        'natureza.max' => 'Natureza muito longa.',
        'tipologia.max' => 'Tipologia muito longa.',
        'data_execucao.date' => 'Data de execução inválida.',
        'data_pagamento.date' => 'Data de pagamento inválida.',
        'valor_total.numeric' => 'O valor total deve ser numérico.',
        'valor_total.min' => 'O valor total não pode ser negativo.',
        'valor_pago.min' => 'O valor pago não pode ser negativo.',
        'status.max' => 'Status muito longo.',
        'arquivo.mimes' => 'Arquivo deve ser PDF ou imagem.',
        'arquivo.max' => 'Arquivo deve ter no máximo 2MB.',
    ];

    public function mount()
    {
        $this->loadFaturas();
    }

    public function loadFaturas()
    {
        $this->faturas = Factura::orderBy('numero_factura', 'desc')->get();
    }

    public function pesquisarFatura()
    {
        $this->successMessage = '';
        $this->errorMessage = '';
        if (trim($this->pesquisa_numero) === '') {
            $this->loadFaturas();
            $this->successMessage = '';
        } else {
            $result = Factura::where('numero_factura', 'like', '%' . $this->pesquisa_numero . '%')->orderBy('numero_factura', 'desc')->get();
            $this->faturas = $result;
            if ($result->isEmpty()) {
                $this->errorMessage = 'Nenhuma fatura encontrada para o número informado.';
                $this->successMessage = '';
            } else {
                $this->successMessage = '';
                $this->errorMessage = '';
            }
        }
    }

    public function resetForm()
    {
        $this->numero_factura = '';
        $this->empresa_nome = '';
        $this->tipo_servico = '';
        $this->natureza = '';
        $this->data_execucao = '';
        $this->data_pagamento = '';
        $this->valor_total = '';
        $this->valor_pago = '';
        $this->observacoes = '';
        $this->arquivo = null;
        $this->status = '';
        $this->fatura_id = null;
        $this->isEdit = false;
    }

    public function save()
    {
        $this->successMessage = '';
        $this->errorMessage = '';
        $rules = $this->rules;
        $validated = $this->validate($rules, $this->messages);
        if (floatval($this->valor_pago) > floatval($this->valor_total)) {
            $this->errorMessage = 'O valor pago não pode ser maior que o valor total.';
            $this->successMessage = '';
            return;
        }

        // Validação: Data de Pagamento >= Data de Execução
        if ($this->data_execucao && $this->data_pagamento) {
            $dataExecucao = strtotime($this->data_execucao);
            $dataPagamento = strtotime($this->data_pagamento);
            if ($dataPagamento < $dataExecucao) {
                $this->errorMessage = 'A Data de Pagamento deve ser maior ou igual à Data de Execução.';
                $this->successMessage = '';
                return;
            }
        }

        // Automatiza status conforme valores de pagamento
        $status = $this->status;
        if (in_array($status, ['aprovada', 'reprovada', 'revisao'])) {
            // Mantém status administrativo se definido
        } else {
            $valor_total = floatval($this->valor_total);
            $valor_pago = floatval($this->valor_pago);
            if ($valor_pago == 0) {
                $status = 'pendente';
            } elseif ($valor_pago > 0 && $valor_pago < $valor_total) {
                $status = 'parcial';
            } elseif ($valor_pago == $valor_total && $valor_total > 0) {
                $status = 'pago';
            } else {
                $status = 'pendente';
            }
        }
        $data = [
            'numero_factura' => $this->numero_factura,
            'empresa_nome' => $this->empresa_nome,
            'tipo_servico' => $this->tipo_servico,
            'natureza' => $this->natureza,
            'data_execucao' => $this->data_execucao,
            'data_pagamento' => $this->data_pagamento,
            'valor_total' => $this->valor_total,
            'valor_pago' => $this->valor_pago,
            'observacoes' => $this->observacoes,
            'arquivo' => null,
            'status' => $status,
            'tipologia' => $this->tipologia,
        ];
        if ($this->arquivo) {
            $data['arquivo'] = $this->arquivo->store('uploads', 'public');
        }
        try {
            if ($this->isEdit && $this->fatura_id) {
                $fatura = Factura::where('numero_factura', $this->fatura_id)->first();
                if ($fatura) {
                    $fatura->update($data);
                    $this->successMessage = 'Fatura atualizada com sucesso!';
                    $this->errorMessage = '';
                } else {
                    $this->errorMessage = 'Fatura não encontrada para edição.';
                    $this->successMessage = '';
                    return;
                }
            } else {
                Factura::create($data);
                $this->successMessage = 'Fatura criada com sucesso!';
                $this->errorMessage = '';
            }
        } catch (\Exception $e) {
            $this->errorMessage = 'Erro ao salvar fatura: ' . $e->getMessage();
            $this->successMessage = '';
            return;
        }
        $this->showForm = false;
        $this->resetForm();
        $this->loadFaturas();
        $this->dispatch('fatura-salva'); // Livewire 3
    }

    public function edit($id)
    {
        $fatura = Factura::where('numero_factura', $id)->first();
        $this->fatura_id = $fatura->numero_factura;
        $this->numero_factura = $fatura->numero_factura;
        $this->empresa_nome = $fatura->empresa_nome;
        $this->tipo_servico = $fatura->tipo_servico;
        $this->natureza = $fatura->natureza;
        $this->data_execucao = $fatura->data_execucao;
        $this->data_pagamento = $fatura->data_pagamento;
        $this->valor_total = $fatura->valor_total;
        $this->valor_pago = $fatura->valor_pago;
        $this->observacoes = $fatura->observacoes;
        $this->arquivo = null;
        $this->status = $fatura->status;
        $this->isEdit = true;
        $this->showForm = true;
        $this->successMessage = '';
    }

    public function delete($id)
    {
        try {
            // Excluir movimentos associados à fatura
            $factura = Factura::where('numero_factura', $id)->first();
            if ($factura) {
                \App\Models\Movimento::where('factura_id', $factura->numero_factura)->delete();
                $factura->delete();
                $this->successMessage = 'Fatura e movimentos associados excluídos com sucesso!';
            } else {
                $this->errorMessage = 'Fatura não encontrada.';
            }
        } catch (\Exception $e) {
            $this->errorMessage = 'Erro ao excluir fatura.';
        }
        $this->resetForm();
        $this->loadFaturas();
    }

    public function render()
    {
        $usuarios = Usuario::orderBy('nome')->get();
        $faturas = Factura::orderBy('numero_factura', 'desc')->get();
        return view('livewire.faturas', [
            'faturas' => $faturas,
            'usuarios' => $usuarios
        ]);
    }
}
