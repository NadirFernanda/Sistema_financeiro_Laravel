<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Facades\Log;

class SetPasswordController extends Controller
{
    public function showForm(Request $request, $token)
    {
        $email = $request->query('email');

        return view('auth.set-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                // Regra mais simples: mínimo 8 caracteres, com letras e números
                PasswordRule::min(8)
                    ->letters()
                    ->numbers(),
            ],
        ], [
            'password.required' => 'A senha é obrigatória.',
            'password.confirmed' => 'A confirmação da senha não coincide.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
        ]);

        try {
            $status = Password::broker('usuarios')->reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (Usuario $usuario, $password) {
                    try {
                        $usuario->senha = Hash::make($password);
                        $usuario->save();
                    } catch (\Throwable $e) {
                        Log::error('Erro ao salvar usuário durante redefinição de senha: ' . $e->getMessage(), [
                            'exception' => $e,
                            'usuario_id' => $usuario->id ?? null,
                        ]);
                        // Não relança a exceção para não impedir o fluxo de redefinição
                    }
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return redirect()->route('login')->with('status', 'Senha salva com sucesso.');
            }

            return back()->withErrors(['email' => __($status)]);
        } catch (\Throwable $e) {
            Log::error('Erro ao redefinir senha: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all(),
            ]);
            return back()->withErrors(['error' => 'Ocorreu um erro interno ao processar sua solicitação. O administrador foi notificado.']);
        }
    }
}
