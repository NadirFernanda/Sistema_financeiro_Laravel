<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimentos', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_ordem')->unique(); // Número de ordem gerado automaticamente
            $table->string('empresa'); // Nome da empresa
            $table->string('descricao'); // Descrição da despesa
            $table->string('natureza_pagamento'); // Natureza do pagamento
            $table->decimal('valor', 12, 2); // Valor do movimento
            $table->string('fonte_financiamento'); // Fonte de financiamento
            $table->dateTime('data_cadastro'); // Data e hora do registro
            $table->unsignedBigInteger('factura_id')->nullable(); // Fatura associada
            $table->enum('tipo', ['entrada', 'saida']); // Tipo do movimento
            $table->timestamps();

            $table->foreign('factura_id')->references('id')->on('facturas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimentos');
    }
};
