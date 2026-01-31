<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

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
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::broker('usuarios')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Usuario $usuario, $password) {
                $usuario->senha = Hash::make($password);
                $usuario->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
