<?php

namespace App\Livewire\Admin\Cliente;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Usuario as User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Form extends Component
{
    use WithFileUploads;

    public $cliente;
    public $clienteId;
    
    // Dados do cliente
    public $nome;
    public $email;
    public $telefone;
    public $endereco;
    public $avatar;
    public $avatarAtual;
    public $senha;
    public $confirmar_senha;
    
    // Status
    public $email_verificado = false;
    public $bloqueado = false;
    
    // UI State
    public $isEditing = false;

    public function mount($id = null)
    {
        $this->isEditing = !is_null($id);
        
        if ($this->isEditing) {
            $this->clienteId = $id;
            $this->carregarCliente();
        }
    }

    protected function rules()
    {
        $rules = [
            'nome' => 'required|string|max:150',
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('usuarios', 'email')->ignore($this->clienteId, 'id_usuario')
            ],
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
            'senha' => $this->isEditing ? 'nullable|min:6' : 'required|min:6',
            'confirmar_senha' => 'same:senha',
            'email_verificado' => 'boolean',
            'bloqueado' => 'boolean',
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'email.unique' => 'Este email já está cadastrado.',
            'senha.required' => 'A senha é obrigatória para novo cliente.',
            'confirmar_senha.same' => 'As senhas não coincidem.',
        ];
    }

    public function carregarCliente()
    {
        $this->cliente = User::findOrFail($this->clienteId);
        
        $this->nome = $this->cliente->nome;
        $this->email = $this->cliente->email;
        $this->telefone = $this->cliente->telefone;
        $this->endereco = $this->cliente->endereco;
        $this->avatarAtual = $this->cliente->avatar_url;
        $this->email_verificado = !is_null($this->cliente->email_verificado_em);
        // $this->bloqueado = $this->cliente->bloqueado; // Adicione este campo se necessário
    }

    public function removerAvatar()
    {
        $this->avatar = null;
        $this->avatarAtual = null;
    }

    public function salvar()
    {
        $this->validate();

        try {
            \DB::beginTransaction();

            if ($this->isEditing) {
                $cliente = $this->cliente;
            } else {
                $cliente = new User();
                $cliente->role = 'cliente';
            }

            $cliente->fill([
                'nome' => $this->nome,
                'email' => $this->email,
                'telefone' => $this->telefone,
                'endereco' => $this->endereco,
            ]);

            // Senha
            if ($this->senha) {
                $cliente->senha = Hash::make($this->senha);
            }

            // Email verificado
            if ($this->email_verificado && !$cliente->email_verificado_em) {
                $cliente->email_verificado_em = now();
            } elseif (!$this->email_verificado && $cliente->email_verificado_em) {
                $cliente->email_verificado_em = null;
            }

            // Upload do avatar
            if ($this->avatar) {
                // Remover avatar anterior se existir
                if ($this->isEditing && $cliente->avatar_url) {
                    \Storage::delete($cliente->avatar_url);
                }
                
                $path = $this->avatar->store('avatars', 'public');
                $cliente->avatar_url = $path;
            } elseif (!$this->avatar && !$this->avatarAtual) {
                $cliente->avatar_url = null;
            }

            $cliente->save();

            \DB::commit();

            session()->flash('success', 
                $this->isEditing 
                    ? 'Cliente atualizado com sucesso!' 
                    : 'Cliente criado com sucesso!'
            );

            return redirect()->route('admin.clientes.show', $cliente->id_usuario);

        } catch (\Exception $e) {
            \DB::rollBack();
            session()->flash('error', 'Erro ao salvar cliente: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.cliente.form');
    }
}