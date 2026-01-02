<?php

namespace App\Livewire\Cliente;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\WithFileUploads;
use App\Models\User;

class Conta extends Component
{
    use WithFileUploads;

    // Dados do usuário
    public $usuario;
    public $nome;
    public $email;
    public $telefone;
    public $endereco;
    public $avatar;
    public $avatarPreview;
    public $avatarUrl;

    // Alterar senha
    public $senha_atual;
    public $nova_senha;
    public $nova_senha_confirmation;
    public $mostrarFormSenha = false;

    // Status
    public $sucesso = false;
    public $erro = false;
    public $mensagem = '';

    public function mount()
    {
        $this->usuario = Auth::user();
        $this->carregarDadosUsuario();
    }

    public function carregarDadosUsuario()
    {
        $this->nome = $this->usuario->nome;
        $this->email = $this->usuario->email;
        $this->telefone = $this->usuario->telefone ?? '';
        $this->endereco = $this->usuario->endereco ?? '';
        $this->avatarUrl = $this->usuario->avatar_url;
        $this->avatarPreview = $this->usuario->avatar_url;
    }

    protected function rules()
    {
        return [
            'nome' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:usuarios,email,' . $this->usuario->id_usuario . ',id_usuario'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'endereco' => ['nullable', 'string', 'max:500'],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB max
        ];
    }

    public function updatedAvatar()
    {
        $this->validateOnly('avatar');
        $this->avatarPreview = $this->avatar->temporaryUrl();
    }

    public function salvarPerfil()
    {
        $this->validate();

        try {
            // Atualizar dados básicos
            $this->usuario->nome = $this->nome;
            $this->usuario->email = $this->email;
            $this->usuario->telefone = $this->telefone;
            $this->usuario->endereco = $this->endereco;

            // Processar avatar se houver
            if ($this->avatar) {
                $nomeArquivo = 'avatar-' . $this->usuario->id_usuario . '-' . time() . '.' . $this->avatar->extension();
                $caminho = $this->avatar->storeAs('avatars', $nomeArquivo, 'public');
                $this->usuario->avatar_url = '/storage/' . $caminho;
                $this->avatarUrl = $this->usuario->avatar_url;
                $this->avatarPreview = $this->usuario->avatar_url;
            }

            $this->usuario->save();

            $this->mostrarMensagem('sucesso', 'Perfil atualizado com sucesso!');
            
            // Atualizar dados na sessão
            Auth::setUser($this->usuario);

        } catch (\Exception $e) {
            $this->mostrarMensagem('erro', 'Erro ao atualizar perfil: ' . $e->getMessage());
        }
    }

    public function rulesSenha()
    {
        return [
            'senha_atual' => ['required', 'current_password'],
            'nova_senha' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    public function atualizarSenha()
    {
        $this->validate($this->rulesSenha());

        try {
            $this->usuario->senha = Hash::make($this->nova_senha);
            $this->usuario->save();

            // Limpar campos
            $this->senha_atual = '';
            $this->nova_senha = '';
            $this->nova_senha_confirmation = '';
            $this->mostrarFormSenha = false;

            $this->mostrarMensagem('sucesso', 'Senha alterada com sucesso!');

        } catch (\Exception $e) {
            $this->mostrarMensagem('erro', 'Erro ao alterar senha: ' . $e->getMessage());
        }
    }

    public function toggleFormSenha()
    {
        $this->mostrarFormSenha = !$this->mostrarFormSenha;
        
        // Limpar campos quando esconder
        if (!$this->mostrarFormSenha) {
            $this->senha_atual = '';
            $this->nova_senha = '';
            $this->nova_senha_confirmation = '';
        }
    }

    public function removerAvatar()
    {
        try {
            // Aqui você removeria o arquivo físico se necessário
            $this->usuario->avatar_url = null;
            $this->usuario->save();
            
            $this->avatarUrl = null;
            $this->avatarPreview = null;
            $this->avatar = null;

            $this->mostrarMensagem('sucesso', 'Foto removida com sucesso!');

        } catch (\Exception $e) {
            $this->mostrarMensagem('erro', 'Erro ao remover foto: ' . $e->getMessage());
        }
    }

    private function mostrarMensagem($tipo, $mensagem)
    {
        $this->sucesso = ($tipo === 'sucesso');
        $this->erro = ($tipo === 'erro');
        $this->mensagem = $mensagem;

        // Auto-esconder mensagem após 5 segundos
        $this->dispatch('mensagem-exibida');
    }

    public function render()
    {
        return view('livewire.cliente.conta')
            ->layout('components.layouts.cliente', [
                'titulo' => 'Minha Conta - B2CStore'
            ]);
    }
}