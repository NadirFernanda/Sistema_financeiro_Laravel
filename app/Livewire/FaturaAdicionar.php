<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Factura;
use Livewire\WithFileUploads;

class FaturaAdicionar extends Component
{
    use WithFileUploads;

    public $numero_factura;
    public $empresa_nome;
    public $tipo_servico;
    public $natureza;
    public $tipologia;
    public $data_execucao;
    public $data_pagamento;
    public $valor_total;
    public $valor_pago;
    public $observacoes;
    public $arquivo;
    public $successMessage = '';
    public $errorMessage = '';

    protected $rules = [
        'numero_factura' => 'required|string|max:100|unique:facturas,numero_factura',
        'empresa_nome' => 'nullable|string|max:255',
        'tipo_servico' => 'nullable|string|max:255',
        'natureza' => 'required',
        'tipologia' => 'required',
        'data_execucao' => 'nullable|date',
        'data_pagamento' => 'nullable|date',
        'valor_total' => 'nullable|numeric|min:0',
        'valor_pago' => 'nullable|numeric|min:0',
        'arquivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ];

    public function save()
    {
        $validated = $this->validate();
        try {
            $data = [
                'numero_factura' => $this->numero_factura,
                'empresa_nome' => $this->empresa_nome,
                'tipo_servico' => $this->tipo_servico,
                'natureza' => $this->natureza,
                'tipologia' => $this->tipologia,
                'data_execucao' => $this->data_execucao,
                'data_pagamento' => $this->data_pagamento,
                'valor_total' => $this->valor_total,
                'valor_pago' => $this->valor_pago,
                'observacoes' => $this->observacoes,
                'arquivo' => null,
            ];
            if ($this->arquivo) {
                $data['arquivo'] = $this->arquivo->store('uploads', 'public');
            }
            Factura::create($data);
            $this->successMessage = 'Fatura adicionada com sucesso!';
            $this->errorMessage = '';
            // Limpar campos se desejar:
            // $this->reset(['numero_factura', 'empresa_nome', 'tipo_servico', 'natureza', 'tipologia', 'data_execucao', 'data_pagamento', 'valor_total', 'valor_pago', 'observacoes', 'arquivo']);
        } catch (\Exception $e) {
            $this->errorMessage = 'Erro ao adicionar fatura.';
            $this->successMessage = '';
        }
    }

    public function render()
    {
        return view('livewire.fatura-adicionar');
    }
}
