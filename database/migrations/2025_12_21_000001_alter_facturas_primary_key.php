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
        Schema::table('facturas', function (Blueprint $table) {
            // Remove chave primária antiga
            $table->dropPrimary();
            // Remove coluna id se existir
            if (Schema::hasColumn('facturas', 'id')) {
                $table->dropColumn('id');
            }
            // Define numero_factura como chave primária
            $table->primary('numero_factura');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropPrimary();
            $table->bigIncrements('id');
        });
    }
};
