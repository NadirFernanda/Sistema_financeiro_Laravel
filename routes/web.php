<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SetPasswordController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/faturas/adicionar', function () {
    return view('fatura-adicionar');
})->name('faturas.adicionar');

Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

Route::get('/relatorios', function () {
    return view('relatorios');
})->name('relatorios');

Route::get('/faturas', function () {
    return view('faturas');
})->name('faturas');

// Rotas para definir senha (primeiro acesso / reset)
Route::get('/definir-senha/{token}', [SetPasswordController::class, 'showForm'])->name('password.reset');
Route::post('/definir-senha', [SetPasswordController::class, 'setPassword'])->name('password.update');


Route::middleware('auth')->group(function () {
    Route::get('/usuarios', function () {
        return view('usuarios');
    })->name('usuarios');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/movimentos', function () {
        return view('movimentos');
    })->name('movimentos');

    // Alterar senha (usuário autenticado)
    Route::get('/profile/password', [PasswordController::class, 'showChangeForm'])->name('password.change');
    Route::post('/profile/password', [PasswordController::class, 'update'])->name('password.change.update');

    // Rota para exibir fatura individual (web)
    Route::get('/facturas/{factura}', function ($factura) {
        // Aqui você pode buscar a fatura pelo ID e passar para a view
        $fatura = \App\Models\Factura::findOrFail($factura);
        return view('fatura-show', ['fatura' => $fatura]);
    })->name('facturas.show');
});

Route::get('/', function () {
    return view('login');
})->name('login.form');

// Rota de logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
