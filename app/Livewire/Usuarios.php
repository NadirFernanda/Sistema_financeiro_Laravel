<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\Usuario;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Password;
use App\Notifications\UsuarioResetPasswordNotification;

class Usuarios extends Component
{
    public $usuarios;
    public $nome;
    public $email;
    public $role;
    public $senha;
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
        'senha.min' => 'A senha deve ter pelo menos 6 caracteres.',
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
        $this->senha = '';
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
        $rules = [
            'nome' => $this->rules['nome'],
            'email' => [
                'required',
                'email',
                Rule::unique('usuarios', 'email')->ignore($this->usuario_id),
            ],
            'role' => $this->rules['role'],
            'senha' => 'nullable|string|min:6',
        ];

        $validated = $this->validate($rules, $this->messages);

        try {
            if ($this->isEdit && $this->usuario_id) {
                $usuario = Usuario::find($this->usuario_id);
                $usuario->update($validated);
                // Se foi informada uma senha manual, atualiza-a
                if (!empty($this->senha)) {
                    $usuario->senha = bcrypt($this->senha);
                    $usuario->save();
                }
                $this->successMessage = 'Usuário atualizado com sucesso!';
            } else {
                // Se o admin informou uma senha manual, usa-a; caso contrário gera senha temporária e envia link de definição
                if (!empty($this->senha)) {
                    $senhaParaSalvar = bcrypt($this->senha);
                    $usuario = Usuario::create([
                        'nome' => $validated['nome'],
                        'email' => $validated['email'],
                        'role' => $validated['role'],
                        'senha' => $senhaParaSalvar,
                    ]);
                    $this->successMessage = 'Usuário criado com sucesso com a senha definida manualmente.';
                } else {
                    $usuario = Usuario::create([
                        'nome' => $validated['nome'],
                        'email' => $validated['email'],
                        'role' => $validated['role'],
                        'senha' => bcrypt(Str::random(32)), // senha temporária forte que será trocada
                    ]);

                    try {
                        // Gera um token de reset no broker "usuarios" e envia notificação com link para definir senha
                        $token = Password::broker('usuarios')->createToken($usuario);
                        $usuario->notify(new UsuarioResetPasswordNotification($token));
                        $this->successMessage = 'Usuário criado com sucesso! Um e-mail foi enviado para que ele defina a própria senha.';
                    } catch (\Exception $e) {
                        $this->successMessage = 'Usuário criado com sucesso, mas houve um erro ao enviar o e-mail para definição da senha.';
                    }
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
        $this->senha = '';
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
