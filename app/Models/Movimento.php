<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_ordem',
        'empresa',
        'descricao',
        'natureza_pagamento',
        'valor',
        'fonte_financiamento',
        'data_cadastro',
        'factura_id',
        'tipo',
    ];

    public function factura()
    {
		// Liga o movimento à fatura usando o número da fatura como chave
		return $this->belongsTo(Factura::class, 'factura_id', 'numero_factura');
    }
}
