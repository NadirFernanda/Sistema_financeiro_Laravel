@extends('layouts.app')

@section('content')
<div style="max-width:640px;margin:48px auto;padding:28px;background:#fff;border-radius:12px;box-shadow:0 6px 30px rgba(0,0,0,0.05);">
    <h2 style="color:#1877F2;margin-bottom:12px;">Alterar senha</h2>

    @if(session('status'))
        <div style="background:#e6ffed;border:1px solid #2e7d32;padding:12px;border-radius:8px;margin-bottom:12px;color:#2e7d32;">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div style="background:#fff6f6;border:1px solid #e74c3c;padding:12px;border-radius:8px;margin-bottom:12px;color:#a61b1b;">
            <ul style="margin:0;padding-left:16px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.change.update') }}">
        @csrf
        <div style="margin-bottom:12px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Senha atual</label>
            <input type="password" name="current_password" class="form-control" required style="width:100%;padding:10px;border:1px solid #e3e6ea;border-radius:8px;">
        </div>

        <div style="margin-bottom:12px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Nova senha</label>
            <input type="password" name="password" class="form-control" required minlength="8" style="width:100%;padding:10px;border:1px solid #e3e6ea;border-radius:8px;">
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Confirmar nova senha</label>
            <input type="password" name="password_confirmation" class="form-control" required style="width:100%;padding:10px;border:1px solid #e3e6ea;border-radius:8px;">
        </div>

        <div style="display:flex;gap:12px;align-items:center;">
            <button type="submit" class="btn" style="background:#1877F2;color:#fff;padding:10px 18px;border-radius:8px;border:none;">Salvar senha</button>
            <a href="{{ route('dashboard') }}" style="color:#6c757d;text-decoration:none;">Cancelar</a>
        </div>
    </form>
</div>
@endsection
