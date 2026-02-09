
@extends('layouts.app')

@section('content')

<style>
    body { background: #f4f6fa !important; }
    .login-logo {
        max-width: 120px;
        width: 100%;
        height: auto;
        margin-bottom: 10px;
    }
    .login-title {
        color: #1877F2;
        font-weight: bold;
        font-size: 2rem;
        margin-bottom: 0;
    }
    .login-subtitle {
        color: #222;
        font-size: 1.1rem;
        margin-bottom: 30px;
    }
    .login-card {
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        background: #fff;
        padding: 32px 28px 24px 28px;
        max-width: 420px;
        width: 100%;
    }
    .login-btn {
        background: #1877F2;
        color: #fff;
        border-radius: 24px;
        font-weight: bold;
        font-size: 1.1rem;
        padding: 10px 0;
        width: 100%;
        border: none;
        margin-top: 10px;
        margin-bottom: 18px;
        transition: background 0.2s;
    }
    .login-btn:hover {
        background: #145db2;
    }
    .access-levels {
        font-size: 0.98rem;
        margin-top: 18px;
    }
    /* ...existing code... */
</style>

<div style="min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #f4f6fa;">
    <div class="mb-2" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <img src="/imagem/logo.png" alt="Logo" class="login-logo" style="display: block; margin: 0 auto;">
        <div class="login-subtitle" style="font-weight: bold; font-size: 1.35rem; text-align: center;">SISTEMA FINANCEIRO</div>
    </div>
    <div class="login-card mx-auto">
        <h4 class="mb-4" style="font-weight: bold; text-align: center;">Acesso ao sistema</h4>
        @if (session('success'))
            <div class="mb-4 text-green-600 text-sm text-center">
                {{ session('success') }}
            </div>
        @endif
        @if (session('status'))
            <div class="mb-4 text-green-600 text-sm text-center">
                {{ session('status') }}
            </div>
        @endif
        {{-- O componente Livewire já inclui o formulário --}}
        <form method="POST" action="/login">
            @csrf
            <div class="mb-5">
                <label for="email" class="form-label" style="margin-bottom:8px;">Email</label>
                <input type="email" class="form-control w-100" style="min-width:98%; max-width:100%; margin-bottom:18px; height:40px; font-size:1.08rem; border-radius:12px; border: 1.5px solid rgba(0,0,0,0.10); background:rgba(255,255,255,0.98);" id="email" name="email" placeholder="seu.email@ispb.ao" required autofocus>
            </div>
            <div class="mb-5">
                <label for="password" class="form-label" style="margin-bottom:8px;">Senha</label>
                <input type="password" class="form-control w-100" style="min-width:98%; max-width:100%; margin-bottom:18px; height:40px; font-size:1.08rem; border-radius:12px; border: 1.5px solid rgba(0,0,0,0.10);" id="password" name="password" placeholder="Digite sua senha" required>
            </div>
            <div style="display: flex; justify-content: center;">
                <button type="submit" class="login-btn" style="width:180px;">Entrar</button>
            </div>
        </form>
        <!-- Níveis de acesso removidos da tela de login -->
    </div>
</div>
@endsection


