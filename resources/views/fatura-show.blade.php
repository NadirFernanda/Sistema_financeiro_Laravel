@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Fatura: {{ $fatura->numero_factura }}</h1>
    <ul>
        <li><strong>Empresa:</strong> {{ $fatura->empresa }}</li>
        <li><strong>Tipo de Serviço:</strong> {{ $fatura->tipo_servico }}</li>
        <li><strong>Natureza:</strong> {{ $fatura->natureza }}</li>
        <li><strong>Tipologia:</strong> {{ $fatura->tipologia }}</li>
        <li><strong>Data Execução:</strong> {{ $fatura->data_execucao }}</li>
        <li><strong>Data Pagamento:</strong> {{ $fatura->data_pagamento }}</li>
        <li><strong>Valor Total:</strong> Kz {{ number_format($fatura->valor_total, 2, ',', '.') }}</li>
        <li><strong>Valor Pago:</strong> Kz {{ number_format($fatura->valor_pago, 2, ',', '.') }}</li>
        <li><strong>Status:</strong> {{ $fatura->status }}</li>
    </ul>
</div>
@endsection
