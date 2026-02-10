<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_set_password_with_valid_token()
    {
        // Cria usuário de teste
        $user = Usuario::factory()->create([
            'senha' => null,
        ]);

        // Gera token usando o broker personalizado 'usuarios'
        $token = Password::broker('usuarios')->createToken($user);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'Secret1234',
            'password_confirmation' => 'Secret1234',
        ]);

        $response->assertRedirect(route('login.form'));
        $response->assertSessionHas('status', 'Senha salva com sucesso.');

        $this->assertTrue(Hash::check('Secret1234', $user->fresh()->senha));
    }
}
