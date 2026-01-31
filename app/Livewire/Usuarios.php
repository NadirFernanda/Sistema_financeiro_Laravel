<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\Usuario;
use Illuminate\Support\Facades\Password;

class Usuarios extends Component
{
    public $usuarios;
    public $nome;
    public $email;
    public $role;
    public $usuario_id;
    public $isEdit = false;
    public $showForm = false;
    public $successMessage = '';
    public $errorMessage = '';


    protected $rules = [
        'nome' => 'required|min:3',
        'email' => 'required|email',
        'role' => 'required|in:admin,financeiro,usuario,secretaria,contratacao,executor,gabinete,presidente',
    ];

    protected $messages = [
        'nome.required' => 'O nome é obrigatório.',
        'nome.min' => 'O nome deve ter pelo menos 3 caracteres.',
        'email.required' => 'O e-mail é obrigatório.',
        'email.email' => 'Informe um e-mail válido.',
        'role.required' => 'A função é obrigatória.',
        'role.in' => 'Função inválida. Use admin, financeiro, usuario, secretaria, contratacao, executor, gabinete ou presidente.',
    ];

    public function mount()
    {
        $this->loadUsuarios();
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
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
        $this->showForm = false;
        $this->successMessage = '';
        $this->errorMessage = '';
    }

    public function save()
    {
        $this->successMessage = '';
        $this->errorMessage = '';
        $rules = $this->rules;

        // Em PostgreSQL, passar um ID vazio ('') para a regra unique com ignore causa erro de conversão.
        // Por isso, só adicionamos o ID a ser ignorado quando estamos em modo edição.
        if ($this->isEdit && $this->usuario_id) {
            $rules['email'] .= '|unique:usuarios,email,' . $this->usuario_id;
        } else {
            $rules['email'] .= '|unique:usuarios,email';
        }
        $validated = $this->validate($rules, $this->messages);

        try {
            if ($this->isEdit && $this->usuario_id) {
                $usuario = Usuario::find($this->usuario_id);
                $usuario->update($validated);
                $this->successMessage = 'Usuário atualizado com sucesso!';
            } else {
                $usuario = Usuario::create($validated);

                try {
                    Password::broker('usuarios')->sendResetLink([
                        'email' => $usuario->email,
                    ]);
                    $this->successMessage = 'Usuário criado com sucesso! Um e-mail foi enviado para definir a senha.';
                } catch (\Exception $e) {
                    $this->successMessage = 'Usuário criado com sucesso, mas houve um erro ao enviar o e-mail de definição de senha.';
                }
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
