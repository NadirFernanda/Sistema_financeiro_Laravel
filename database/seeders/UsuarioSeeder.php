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
        // Admin permanece intacto
        if (!Usuario::where('email', 'admin@admin.com')->exists()) {
            Usuario::create([
                'nome' => 'Admin',
                'email' => 'admin@admin.com',
                'role' => 'admin',
                'senha' => Hash::make('admin123'),
            ]);
        }

        $usuariosTeste = [
            ['nome' => 'Secretaria', 'email' => 'secretaria@teste.com', 'role' => 'secretaria', 'senha' => 'secretaria123'],
            ['nome' => 'Contratação Pública', 'email' => 'contratacao@teste.com', 'role' => 'contratacao', 'senha' => 'contratacao123'],
            ['nome' => 'Executor', 'email' => 'executor@teste.com', 'role' => 'executor', 'senha' => 'executor123'],
            ['nome' => 'Gabinete do Presidente', 'email' => 'gabinete@teste.com', 'role' => 'gabinete', 'senha' => 'gabinete123'],
            ['nome' => 'Presidente', 'email' => 'presidente@teste.com', 'role' => 'presidente', 'senha' => 'presidente123'],
            ['nome' => 'Financeiro', 'email' => 'financeiro@teste.com', 'role' => 'financeiro', 'senha' => 'financeiro123'],
            ['nome' => 'Usuário', 'email' => 'usuario@teste.com', 'role' => 'usuario', 'senha' => 'usuario123'],
        ];
        foreach ($usuariosTeste as $u) {
            if (!Usuario::where('email', $u['email'])->exists()) {
                Usuario::create([
                    'nome' => $u['nome'],
                    'email' => $u['email'],
                    'role' => $u['role'],
                    'senha' => Hash::make($u['senha']),
                ]);
            }
        }
    }
}
