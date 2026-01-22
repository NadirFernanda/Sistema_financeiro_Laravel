<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Buscar notificações do usuário
    public function notificacoes($id)
    {
        $notificacoes = DB::table('notifications')->where('user_id', $id)->orderByDesc('created_at')->get();
        return response()->json(['notificacoes' => $notificacoes]);
    }
    /**
     * Display a listing of the resource.
     */
    // Listar usuários
    public function index()
    {
        $usuarios = Usuario::orderBy('id')->get();
        return response()->json(['usuarios' => $usuarios]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // Adicionar usuário
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:usuarios,email',
            'role' => 'required',
            'senha' => 'required|min:6',
        ]);
        $validated['senha'] = Hash::make($validated['senha']);
        $usuario = Usuario::create($validated);
        return response()->json(['usuario' => $usuario], 201);
    }

    /**
     * Display the specified resource.
     */
    // Exibir usuário específico
    public function show($id)
    {
        $usuario = Usuario::findOrFail($id);
        return response()->json(['usuario' => $usuario]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // Editar usuário
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $validated = $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:usuarios,email,' . $id,
            'role' => 'required',
        ]);
        $usuario->update($validated);
        return response()->json(['usuario' => $usuario]);
    }

    /**
     * Remove the specified resource from storage.
     */
    // Excluir usuário
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
        return response()->json(['success' => true]);
    }
}
