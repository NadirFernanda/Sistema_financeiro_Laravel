<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
    /**
     * Adiciona o header CSP para liberar Livewire no servidor embutido
     */
    public function handle($request, \Closure $next)
    {
        $response = parent::handle($request, $next);
        $response->headers->set('Content-Security-Policy', "script-src 'self' 'unsafe-eval' 'unsafe-inline' https://cdn.jsdelivr.net;");
        return $response;
    }
}
