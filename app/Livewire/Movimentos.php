<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\Movimento;
use Illuminate\Support\Facades\DB;


class Movimentos extends Component
{
    // Garante que ao mudar para 'entrada', o campo factura_id é limpo
    public function updatedTipo($value)
    {
        if ($value === 'entrada') {
            $this->factura_id = null;
            $this->resetErrorBag('factura_id');
        }
    }

    // Quando o usuário seleciona uma fatura, removemos a mensagem de erro imediatamente
    public function updatedFacturaId($value)
    {
        if (!empty($value)) {
            $this->resetErrorBag('factura_id');
        }
    }

    public function getPodeEditarProperty()
    {
        $user = auth()->user();
        if (!$user || !isset($user->role)) return false;
        $role = strtolower($user->role);
        return in_array($role, ['admin', 'secretaria']);
    }

    public function getPodeEliminarProperty()
    {
        $user = auth()->user();
        if (!$user || !isset($user->role)) return false;
        $role = strtolower($user->role);
        return in_array($role, ['admin', 'secretaria']);
    }
    // Permissão pública para uso no Blade (igual Faturas)
    public function getPodeInserirProperty()
    {
        $user = auth()->user();
        if (!$user || !isset($user->role)) return false;
        $role = strtolower($user->role);
        return in_array($role, ['admin', 'secretaria', 'contratacao']);
    }
    protected $messages = [
        'empresa.required' => 'O campo Empresa é obrigatório.',
        'descricao.required' => 'O campo Descrição da Despesa é obrigatório.',
        'natureza_pagamento.required' => 'O campo Natureza Pagamento é obrigatório.',
        'valor.required' => 'O campo Valor é obrigatório.',
        'valor.min' => 'O valor deve ser maior que zero.',
        'fonte_financiamento.required' => 'O campo Fonte de Financiamento é obrigatório.',
        'data_cadastro.required' => 'O campo Data de Cadastro é obrigatório.',
        'tipo.required' => 'O campo Tipo é obrigatório.',
        'factura_id.required' => 'O campo Fatura é obrigatório.',
        'factura_id.exists' => 'A fatura selecionada não existe.',
    ];
    public $movimentos = [];
    public $numero_ordem;
    public $empresa;
    public $descricao;
    public $natureza_pagamento;
    public $valor;
    public $fonte_financiamento;
    public $data_cadastro;
    public $factura_id = null;
    public $tipo = 'entrada';
    public $movimento_id;
    public $data_inicio;
    public $data_fim;
    public $modoEdicao = false;
    public $mensagem = '';
    public $facturas = [];

    public $total_entradas = 0;
    public $total_saidas = 0;
    public $saldo = 0;

    public function mount()
    {
        $this->carregarFacturas();
        $this->carregarMovimentos();
        $this->calcularResumo();
    }

    public function carregarFacturas()
    {
        $this->facturas = \App\Models\Factura::all();
    }

    public function carregarMovimentos()
    {
        $query = Movimento::query();
        if ($this->data_inicio && $this->data_fim) {
            $query->whereBetween('data_cadastro', [$this->data_inicio, $this->data_fim]);
        }
        $this->movimentos = $query->orderByDesc('data_cadastro')->get();
        $this->calcularResumo();
    }

    public function calcularResumo()
    {
        $this->total_entradas = Movimento::where('tipo', 'entrada')->sum('valor');
        $this->total_saidas = Movimento::where('tipo', 'saida')->sum('valor');
        $this->saldo = $this->total_entradas - $this->total_saidas;
    }

    public function salvarMovimento()
    {
        // Se vier string vazia, normaliza para null
        if ($this->factura_id === '') {
            $this->factura_id = null;
        }
        $rules = [
            'empresa' => 'required|string',
            'descricao' => 'required|string',
            'natureza_pagamento' => 'required|string',
            'valor' => 'required|numeric|min:0.01',
            'fonte_financiamento' => 'required|string',
            'data_cadastro' => 'required|date',
            'tipo' => 'required|in:entrada,saida',
            'factura_id' => $this->tipo === 'saida' ? 'required|exists:facturas,id' : 'nullable',
        ];
        $this->validate($rules, $this->messages);

        // Gerar número de ordem automaticamente
        $ultimo = Movimento::orderByDesc('numero_ordem')->first();
        $novo_numero = $ultimo ? $ultimo->numero_ordem + 1 : 1;

        if ($this->modoEdicao && $this->movimento_id) {
            $mov = Movimento::find($this->movimento_id);
            if ($mov) {
                $mov->update([
                    'numero_ordem' => $mov->numero_ordem,
                    'empresa' => $this->empresa,
                    'descricao' => $this->descricao,
                    'natureza_pagamento' => $this->natureza_pagamento,
                    'valor' => $this->valor,
                    'fonte_financiamento' => $this->fonte_financiamento,
                    'data_cadastro' => $this->data_cadastro,
                    'factura_id' => $this->factura_id,
                    'tipo' => $this->tipo,
                ]);
                $this->mensagem = 'Movimento atualizado com sucesso!';
            }
        } else {
            Movimento::create([
                'numero_ordem' => $novo_numero,
                'empresa' => $this->empresa,
                'descricao' => $this->descricao,
                'natureza_pagamento' => $this->natureza_pagamento,
                'valor' => $this->valor,
                'fonte_financiamento' => $this->fonte_financiamento,
                'data_cadastro' => $this->data_cadastro,
                'factura_id' => $this->factura_id,
                'tipo' => $this->tipo,
            ]);
            $this->mensagem = 'Movimento cadastrado com sucesso!';
        }
        $this->resetarFormulario();
        $this->carregarMovimentos();
    }

    public function editarMovimento($id)
    {
        $mov = Movimento::find($id);
        if ($mov) {
            $this->movimento_id = $mov->id;
            $this->empresa = $mov->empresa;
            $this->descricao = $mov->descricao;
            $this->natureza_pagamento = $mov->natureza_pagamento;
            $this->valor = $mov->valor;
            $this->fonte_financiamento = $mov->fonte_financiamento;
            $this->data_cadastro = $mov->data_cadastro;
            $this->factura_id = $mov->factura_id;
            $this->tipo = $mov->tipo;
            $this->modoEdicao = true;
        }
    }

    public function excluirMovimento($id)
    {
        Movimento::destroy($id);
        $this->mensagem = 'Movimento excluído com sucesso!';
        $this->resetarFormulario();
        $this->carregarMovimentos();
    }

    public function resetarFormulario()
    {
        $this->movimento_id = null;
        $this->numero_ordem = '';
        $this->empresa = '';
        $this->descricao = '';
        $this->natureza_pagamento = '';
        $this->valor = '';
        $this->fonte_financiamento = '';
        $this->data_cadastro = '';
        $this->factura_id = null;
        $this->tipo = 'entrada';
        $this->modoEdicao = false;
        $this->data_inicio = '';
        $this->data_fim = '';
        $this->carregarMovimentos();
    }

    public function filtrarPorData()
    {
        $this->carregarMovimentos();
    }

    public function render()
    {
        return view('livewire.movimentos');
    }
}
