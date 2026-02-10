<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão - Login</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @livewireStyles
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" onerror="this.onerror=null;this.href='/css/bootstrap.min.css'">
</head>
<body>
    <!-- Topbar: mostra usuário logado e papel -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Sistema Financeiro</a>
            @if(Auth::check())
                <div class="ms-auto d-flex align-items-center">
                    <span class="me-3">Olá, {{ Auth::user()->nome }} (<strong>{{ ucfirst(Auth::user()->role) }}</strong>)</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm">Sair</button>
                    </form>
                </div>
            @else
                <div class="ms-auto">
                    <a href="{{ route('login.form') }}" class="btn btn-link">Entrar</a>
                </div>
            @endif
        </div>
    </nav>

    <main class="container py-5">
        @yield('content')
    </main>
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
