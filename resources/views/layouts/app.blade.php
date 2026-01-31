<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão - Login</title>
    <link rel="icon" type="image/png" href="{{ asset('imagem/logo.png') }}">
    @livewireStyles
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" onerror="this.onerror=null;this.href='/css/bootstrap.min.css'">
</head>
<body>
    <!-- Barra azul removida completamente -->
    <main class="container py-5">
        @yield('content')
    </main>
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
