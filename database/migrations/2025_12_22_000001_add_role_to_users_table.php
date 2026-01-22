<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Já existe a coluna 'role' na tabela users. Nenhuma ação necessária.
        // Schema::table('users', function (Blueprint $table) {
        //     $table->string('role')->default('executor')->after('password');
        // });
    }

    public function down()
    {
        // Nenhuma ação necessária para remover a coluna 'role'.
        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn('role');
        // });
    }
};
