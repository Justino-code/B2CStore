<?php

namespace App\Livewire\Admin\Perfil;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use App\Models\Usuario;

use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Index extends Component
{
    use WithFileUploads;

    public $usuario;
    public $nome;
    public $email;
    public $telefone;
    
    // Endereço
    public $rua;
    public $numero;
    public $bairro;
    public $municipio;
    public $provincia;
    public $complemento;
    public $referencia;
    
    // Alterar senha
    public $senha_atual;
    public $nova_senha;
    public $nova_senha_confirmation;
    
    // Upload de avatar
    public $avatar;
    public $avatar_url;
    
    // Estados
    public $mostrarFormSenha = false;
    public $mostrarFormEndereco = false;

    public function mount()
    {
        $this->usuario = Auth::user();
        $this->carregarDadosUsuario();
    }

    private function carregarDadosUsuario()
    {
        $this->nome = $this->usuario->nome;
        $this->email = $this->usuario->email;
        $this->telefone = $this->usuario->telefone;
        $this->avatar_url = $this->usuario->avatar_url;
        
        // Carregar endereço
        if ($this->usuario->endereco) {
            $enderecoArray = $this->usuario->endereco_array;
            $this->rua = $enderecoArray['rua'] ?? '';
            $this->numero = $enderecoArray['numero'] ?? '';
            $this->bairro = $enderecoArray['bairro'] ?? '';
            $this->municipio = $enderecoArray['municipio'] ?? '';
            $this->provincia = $enderecoArray['provincia'] ?? '';
            $this->complemento = $enderecoArray['complemento'] ?? '';
            $this->referencia = $enderecoArray['referencia'] ?? '';
        }
    }

    public function rules()
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,email,' . $this->usuario->id_usuario . ',id_usuario'],
            'telefone' => ['nullable', 'string', 'max:20'],
            
            // Regras para senha (quando estiver alterando)
            'senha_atual' => ['required_with:nova_senha', 'current_password:web'],
            'nova_senha' => ['nullable', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
            
            // Regras para avatar
            'avatar' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png,gif'],
            
            // Regras para endereço
            'rua' => ['nullable', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'bairro' => ['nullable', 'string', 'max:255'],
            'municipio' => ['nullable', 'string', 'max:255'],
            'provincia' => ['nullable', 'string', 'max:255'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'referencia' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Digite um email válido.',
            'email.unique' => 'Este email já está em uso.',
            'senha_atual.required_with' => 'A senha atual é obrigatória.',
            'senha_atual.current_password' => 'A senha atual está incorreta.',
            'nova_senha.confirmed' => 'As senhas não coincidem.',
            'nova_senha.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'avatar.image' => 'O arquivo deve ser uma imagem.',
            'avatar.max' => 'A imagem deve ter no máximo 2MB.',
            'avatar.mimes' => 'A imagem deve ser JPG, JPEG, PNG ou GIF.',
        ];
    }

    public function atualizarPerfil()
    {
        $this->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,email,' . $this->usuario->id_usuario . ',id_usuario'],
            'telefone' => ['nullable', 'string', 'max:20'],
        ]);

        try {
            $this->usuario->update([
                'nome' => $this->nome,
                'email' => $this->email,
                'telefone' => $this->telefone,
            ]);

            $this->dispatch('notify', 
                type: 'success',
                message: 'Perfil atualizado com sucesso!'
            );

        } catch (\Exception $e) {
            $this->dispatch('notify',
                type: 'error',
                message: 'Erro ao atualizar perfil: ' . $e->getMessage()
            );
        }
    }

    public function atualizarSenha()
    {
        $this->validate([
            'senha_atual' => ['required', 'current_password:web'],
            'nova_senha' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        try {
            $this->usuario->update([
                'senha' => Hash::make($this->nova_senha),
            ]);

            // Limpar campos
            $this->senha_atual = '';
            $this->nova_senha = '';
            $this->nova_senha_confirmation = '';
            $this->mostrarFormSenha = false;

            $this->dispatch('notify', 
                type: 'success',
                message: 'Senha alterada com sucesso!'
            );

        } catch (\Exception $e) {
            $this->dispatch('notify',
                type: 'error',
                message: 'Erro ao alterar senha: ' . $e->getMessage()
            );
        }
    }

    public function atualizarEndereco()
    {
        $this->validate([
            'rua' => ['nullable', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'bairro' => ['nullable', 'string', 'max:255'],
            'municipio' => ['nullable', 'string', 'max:255'],
            'provincia' => ['nullable', 'string', 'max:255'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'referencia' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            // Construir endereço no formato para Angola
            $enderecoParts = [
                $this->rua,
                $this->numero,
                $this->bairro,
                $this->municipio,
                $this->provincia,
                $this->complemento,
                $this->referencia
            ];
            
            $endereco = implode(', ', array_filter($enderecoParts, function($part) {
                return !empty(trim($part));
            }));

            $this->usuario->update([
                'endereco' => $endereco,
            ]);

            $this->mostrarFormEndereco = false;

            $this->dispatch('notify', 
                type: 'success',
                message: 'Endereço atualizado com sucesso!'
            );

        } catch (\Exception $e) {
            $this->dispatch('notify',
                type: 'error',
                message: 'Erro ao atualizar endereço: ' . $e->getMessage()
            );
        }
    }

    public function atualizarAvatar()
    {
        $this->validate([
            'avatar' => ['required', 'image', 'max:2048', 'mimes:jpg,jpeg,png,gif'],
        ]);

        try {
            // Remover avatar antigo se existir
            if ($this->usuario->avatar_url && Storage::disk('public')->exists($this->usuario->avatar_url)) {
                Storage::disk('public')->delete($this->usuario->avatar_url);
            }

            // Upload do novo avatar
            $path = $this->avatar->store('avatars', 'public');
            
            $this->usuario->update([
                'avatar_url' => $path,
            ]);

            // Atualizar a URL do avatar
            $this->avatar_url = $path;
            $this->avatar = null;

            $this->dispatch('notify', 
                type: 'success',
                message: 'Foto de perfil atualizada com sucesso!'
            );

        } catch (\Exception $e) {
            $this->dispatch('notify',
                type: 'error',
                message: 'Erro ao atualizar foto de perfil: ' . $e->getMessage()
            );
        }
    }

    public function removerAvatar()
    {
        try {
            if ($this->usuario->avatar_url && Storage::disk('public')->exists($this->usuario->avatar_url)) {
                Storage::disk('public')->delete($this->usuario->avatar_url);
            }

            $this->usuario->update([
                'avatar_url' => null,
            ]);

            $this->avatar_url = null;

            $this->dispatch('notify', 
                type: 'success',
                message: 'Foto de perfil removida com sucesso!'
            );

        } catch (\Exception $e) {
            $this->dispatch('notify',
                type: 'error',
                message: 'Erro ao remover foto de perfil: ' . $e->getMessage()
            );
        }
    }

    public function render()
    {
        return view('livewire.admin.perfil.index');
    }
}