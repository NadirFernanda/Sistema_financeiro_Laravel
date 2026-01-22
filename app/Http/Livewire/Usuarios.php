<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class Usuarios extends Component
{
    public $usuarios;

    public function render()
    {
        $this->usuarios = User::all();
        return view('livewire.usuarios');
    }

    public function create()
    {
        // lógica para criar usuário
    }

    public function edit($id)
    {
        // lógica para editar usuário
    }

    public function delete($id)
    {
        // lógica para deletar usuário
    }
}