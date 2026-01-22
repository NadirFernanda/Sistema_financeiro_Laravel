<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\Usuario;

class Usuarios extends Component
{
    public $usuarios;
    public $nome;
    public $email;
    public $role;
    public $usuario_id;
    public $isEdit = false;
    public $successMessage = '';
    public $errorMessage = '';

    protected $rules = [
        'nome' => 'required|min:3',
        'email' => 'required|email',
        'role' => 'required|in:admin,financeiro,usuario',
    ];

    protected $messages = [
        'nome.required' => 'O nome é obrigatório.',
        'nome.min' => 'O nome deve ter pelo menos 3 caracteres.',
        'email.required' => 'O e-mail é obrigatório.',
        'email.email' => 'Informe um e-mail válido.',
        'role.required' => 'A função é obrigatória.',
        'role.in' => 'Função inválida. Use admin, financeiro ou usuario.',
    ];

    public function mount()
    {
        $this->loadUsuarios();
    }

    public function loadUsuarios()
    {
        $this->usuarios = Usuario::orderBy('id')->get();
    }

    public function resetForm()
    {
        $this->nome = '';
        $this->email = '';
        $this->role = '';
        $this->usuario_id = null;
        $this->isEdit = false;
        $this->successMessage = '';
        $this->errorMessage = '';
    }

    public function save()
    {
        $this->successMessage = '';
        $this->errorMessage = '';
        $rules = $this->rules;
        $rules['email'] .= '|unique:usuarios,email,' . $this->usuario_id;
        $validated = $this->validate($rules, $this->messages);

        try {
            if ($this->isEdit && $this->usuario_id) {
                $usuario = Usuario::find($this->usuario_id);
                $usuario->update($validated);
                $this->successMessage = 'Usuário atualizado com sucesso!';
            } else {
                Usuario::create($validated);
                $this->successMessage = 'Usuário criado com sucesso!';
            }
            $this->resetForm();
            $this->loadUsuarios();
        } catch (\Exception $e) {
            $this->errorMessage = 'Erro ao salvar usuário.';
        }
    }

    public function edit($id)
    {
        $usuario = Usuario::find($id);
        $this->usuario_id = $usuario->id;
        $this->nome = $usuario->nome;
        $this->email = $usuario->email;
        $this->role = $usuario->role;
        $this->isEdit = true;
        $this->successMessage = '';
        $this->errorMessage = '';
    }

    public function delete($id)
    {
        try {
            Usuario::find($id)?->delete();
            $this->successMessage = 'Usuário excluído com sucesso!';
        } catch (\Exception $e) {
            $this->errorMessage = 'Erro ao excluir usuário.';
        }
        $this->resetForm();
        $this->loadUsuarios();
    }

    public function render()
    {
        return view('livewire.usuarios', [
            'usuarios' => $this->usuarios
        ]);
    }
}
