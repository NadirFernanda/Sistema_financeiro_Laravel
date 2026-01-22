<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    // Valor pendente é calculado automaticamente
    public function getValorPendenteAttribute()
    {
        $total = $this->valor_total ?? 0;
        $pago = $this->valor_pago ?? 0;
        return $total - $pago;
    }

    protected $primaryKey = 'numero_factura';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'numero_factura',
        'empresa_nome',
        'tipo_servico',
        'natureza',
        'tipologia',
        'data_execucao',
        'data_pagamento',
        'valor_total',
        'valor_pago',
        'observacoes',
        'arquivo',
        'status',
    ];
}
