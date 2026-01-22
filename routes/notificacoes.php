<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/usuarios/{id}/notificacoes', [UserController::class, 'notificacoes']);
