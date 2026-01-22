<?php
Route::get('/faturas/adicionar', function () {
    return view('fatura-adicionar');
})->name('faturas.adicionar');
use App\Http\Controllers\AuthController;
Route::post('/login', [AuthController::class, 'login'])->name('login');

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

Route::get('/relatorios', function () {
    return view('relatorios');
})->name('relatorios');

Route::get('/faturas', function () {
    return view('faturas');
})->name('faturas');

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
});

Route::get('/', function () {
    return view('login');
})->name('login');

// Rota de logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
