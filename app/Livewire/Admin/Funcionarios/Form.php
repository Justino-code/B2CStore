<?php

namespace App\Livewire\Admin\Funcionarios;

use App\Models\Usuario;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.admin')]
class Form extends Component
{
    use WithFileUploads;

    public Usuario $funcionario;
    public $nome;
    public $email;
    public $telefone;
    public $endereco;
    public $status;
    public $role;
    public $avatar;
    public $password = '';
    public $password_confirmation = '';
    public $showPassword = false;
    public $isEditing = false;

    protected $listeners = ['avatarRemoved', 'confirmAvatarRemoval'];

    public function mount(Usuario $funcionario)
    {
        $this->isEditing = $funcionario->exists;
        
        if ($this->isEditing) {
            $this->funcionario = $funcionario;
            // Garantir que não estamos editando um cliente
            if ($this->funcionario->role === 'cliente') {
                abort(404, 'Cliente não pode ser editado como funcionário');
            }
            
            // Sincronizar as propriedades públicas com o modelo
            $this->nome = $this->funcionario->nome;
            $this->email = $this->funcionario->email;
            $this->telefone = $this->funcionario->telefone;
            $this->endereco = $this->funcionario->endereco;
            $this->status = $this->funcionario->status;
            $this->role = $this->funcionario->role;
        } else {
            $this->funcionario = new Usuario();
            // Valores padrão para novo funcionário
            $this->status = 'ativo';
            $this->role = 'operador';
        }
    }

    public function rules()
    {
        $rules = [
            'nome' => 'required|min:3|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                $this->isEditing 
                    ? 'unique:usuarios,email,' . $this->funcionario->id_usuario . ',id_usuario'
                    : 'unique:usuarios,email'
            ],
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:500',
            'status' => 'required|in:ativo,inativo',
            'role' => 'required|in:admin,gerente,operador,suporte',
            'avatar' => 'nullable|image|max:2048', // 2MB max
        ];

        // Regras para senha (obrigatória apenas na criação)
        if (!$this->isEditing) {
            $rules['password'] = [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ];
        } else {
            $rules['password'] = 'nullable|confirmed|min:8';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Digite um email válido.',
            'email.unique' => 'Este email já está em uso.',
            'password.required' => 'A senha é obrigatória.',
            'password.confirmed' => 'As senhas não conferem.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'role.required' => 'O cargo é obrigatório.',
            'status.required' => 'O status é obrigatório.',
            'avatar.image' => 'O arquivo deve ser uma imagem.',
            'avatar.max' => 'A imagem não pode ser maior que 2MB.',
        ];
    }

    public function save()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $firstError = reset($errors)[0] ?? 'Erro de validação';
            
            $this->dispatch('notify',
                type: 'error',
                message: $firstError
            );
            return;
        }

        try {
            // Atualizar o modelo com as propriedades públicas
            $this->funcionario->nome = $this->nome;
            $this->funcionario->email = $this->email;
            $this->funcionario->telefone = $this->telefone;
            $this->funcionario->endereco = $this->endereco;
            $this->funcionario->status = $this->status;
            $this->funcionario->role = $this->role;

            // Se houver upload de avatar, processá-lo
            if ($this->avatar) {
                $path = $this->avatar->store('avatars', 'public');
                $this->funcionario->avatar_url = $path;
            }

            // Se houver senha, criptografá-la
            if (!empty($this->password)) {
                $this->funcionario->senha = Hash::make($this->password);
            }

            // Salvar o funcionário
            $this->funcionario->save();

            $this->dispatch('notify',
                type: 'success',
                message: $this->isEditing 
                    ? 'Funcionário atualizado com sucesso!' 
                    : 'Funcionário criado com sucesso!'
            );

            // Redirecionar para a lista
            return redirect()->route('admin.funcionarios.show', $this->funcionario);

        } catch (\Exception $e) {
            \Log::error('Erro ao salvar funcionário: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->dispatch('notify',
                type: 'error', 
                message: 'Erro ao salvar funcionário.'
            );
        }
    }

    public function avatarRemoved()
    {
        $this->avatar = null;
        $this->funcionario->avatar_url = null;
    }

    #[On('confirm-remove-avatar')]
    public function confirmAvatarRemoval()
    {
        $this->avatarRemoved();
        
        $this->dispatch('notify',
            type: 'success',
            message: 'Foto do perfil removida com sucesso!'
        );
    }

    public function generatePassword()
    {
        $this->password = substr(str_shuffle(
            'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*'
        ), 0, 12);
        
        $this->password_confirmation = $this->password;
        $this->showPassword = true;
        
        $this->dispatch('notify',
            type: 'info',
            message: 'Senha gerada automaticamente!'
        );
    }

    public function render()
    {
        return view('livewire.admin.funcionarios.form');
    }
}