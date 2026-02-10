<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PasswordController extends Controller
{
    public function showChangeForm()
    {
        return view('auth.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->input('current_password'), $user->senha)) {
            return back()->withErrors(['current_password' => 'Senha atual incorreta.']);
        }

        try {
            $user->senha = Hash::make($request->input('password'));
            $user->save();
        } catch (\Exception $e) {
            Log::error('Falha ao gravar nova senha: ' . $e->getMessage());
            return back()->withErrors(['password' => 'Não foi possível atualizar a senha. Tente novamente.']);
        }

        Auth::logout();
        return redirect()->route('login.form')->with('status', 'Senha alterada com sucesso. Faça login novamente.');
    }
}
