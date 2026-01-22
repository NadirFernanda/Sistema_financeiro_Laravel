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
        // Remove a foreign key antiga, se existir
        // Schema::table('movimentos', function (Blueprint $table) {
        //     try {
        //         $table->dropForeign(['factura_id']);
        //     } catch (\Exception $e) {
        //         // Ignora se não existir
        //     }
        // });
        // Alterar a tabela facturas
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropPrimary();
            if (Schema::hasColumn('facturas', 'id')) {
                $table->dropColumn('id');
            }
            $table->primary('numero_factura');
        });
        // Alterar o campo factura_id para string e recriar a foreign key
        Schema::table('movimentos', function (Blueprint $table) {
            $table->string('factura_id')->nullable()->change();
            $table->foreign('factura_id')->references('numero_factura')->on('facturas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movimentos', function (Blueprint $table) {
            $table->dropForeign(['factura_id']);
            $table->bigInteger('factura_id')->change();
        });
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropPrimary();
            $table->bigIncrements('id');
        });
        Schema::table('movimentos', function (Blueprint $table) {
            $table->foreign('factura_id')->references('id')->on('facturas')->onDelete('cascade');
        });
    }
};
