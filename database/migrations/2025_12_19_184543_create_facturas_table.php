<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_factura');
            $table->string('empresa_nome')->nullable();
            $table->string('tipo_servico')->nullable();
            $table->string('natureza');
            $table->string('tipologia');
            $table->date('data_execucao')->nullable();
            $table->date('data_pagamento')->nullable();
            $table->decimal('valor_total', 15, 2)->nullable();
            $table->decimal('valor_pago', 15, 2)->nullable();
            $table->text('observacoes')->nullable();
            $table->string('arquivo')->nullable();
            $table->string('status')->default('pendente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
