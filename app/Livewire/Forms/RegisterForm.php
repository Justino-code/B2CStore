<?php

namespace App\Livewire\Forms;

use App\Models\Usuario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Form;

class RegisterForm extends Form
{
    public string $nome = '';
    public string $email = '';
    public string $senha = '';
    public string $senha_confirmation = '';
    public bool $terms = false;

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:usuarios,email'],
            'senha' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'nome.min' => 'O nome deve ter pelo menos 2 caracteres.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Digite um email válido.',
            'email.unique' => 'Este email já está em uso.',
            'senha.required' => 'A senha é obrigatória.',
            'senha.confirmed' => 'As senhas não coincidem.',
            'terms.required' => 'Você deve aceitar os termos.',
            'terms.accepted' => 'Você deve aceitar os termos.',
        ];
    }

    /**
     * Custom validation attributes
     */
    public function validationAttributes(): array
    {
        return [
            'nome' => 'nome',
            'email' => 'email',
            'senha' => 'senha',
            'terms' => 'termos',
        ];
    }

    /**
     * Register a new user
     */
    public function register(): Usuario
    {
        $validated = $this->validate();

        $usuario = Usuario::create([
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'senha' => Hash::make($validated['senha']),
            'role' => 'cliente',
            'avatar_url' => $this->generateDefaultAvatar($validated['nome']),
        ]);

        event(new Registered($usuario));

        return $usuario;
    }

    /**
     * Generate default avatar URL based on name
     */
    private function generateDefaultAvatar(string $nome): string
    {
        $initials = $this->getInitials($nome);
        $colors = ['0D8ABC', '1ABC9C', '2ECC71', '3498DB', '9B59B6', 'E91E63', 'F1C40F', 'E67E22', 'E74C3C'];
        $color = $colors[array_rand($colors)];
        
        return "https://ui-avatars.com/api/?name=" . urlencode($initials) . "&background=" . $color . "&color=fff&size=128";
    }

    /**
     * Get initials from name
     */
    private function getInitials(string $nome): string
    {
        $words = explode(' ', $nome);
        $initials = '';
        
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }
        
        return substr($initials, 0, 2);
    }

    /**
     * Reset form
     */
    public function resetForm(): void
    {
        $this->reset();
        $this->resetErrorBag();
    }
}