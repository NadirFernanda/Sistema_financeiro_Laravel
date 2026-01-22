<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuario::create([
            'nome' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'senha' => Hash::make('admin123'),
        ]);
    }
}
