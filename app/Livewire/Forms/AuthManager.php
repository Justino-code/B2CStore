<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\LoginForm;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.guest', [
    'header' => 'Bem-vindo de volta',
    'description' => 'Entre na sua conta para continuar'
])]

class AuthManager extends Component
{
    public LoginForm $form;
    
    public bool $showLoginForm = true;
    public ?string $logoutMessage = null;

    /**
     * Handle the login submission
     */
    public function login(): void
    {
        try {
            $this->form->authenticate();
            
            session()->regenerate();
            
            // Emitir evento para atualizar a UI
            $this->dispatch('auth-changed', authenticated: true);
            
            // Redirecionar ou mostrar mensagem
            $this->dispatch('notify', 
                type: 'success', 
                message: 'Login realizado com sucesso!'
            );
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-lançar a exceção para o Livewire mostrar os erros
            throw $e;
        }
    }

    /**
     * Handle logout
     */
    public function logout(): void
    {
        Auth::logout();
        
        session()->invalidate();
        session()->regenerateToken();
        
        // Resetar o formulário
        $this->form->reset();
        
        // Mostrar formulário de login novamente
        $this->showLoginForm = true;
        
        // Emitir evento para atualizar a UI
        $this->dispatch('auth-changed', authenticated: false);
        
        // Mensagem de sucesso
        $this->dispatch('notify', 
            type: 'success', 
            message: 'Logout realizado com sucesso!'
        );
    }

    /**
     * Toggle between login and logout views
     */
    public function toggleView(): void
    {
        $this->showLoginForm = !$this->showLoginForm;
    }

    /**
     * Check if user is authenticated
     */
    public function isAuthenticated(): bool
    {
        return Auth::check();
    }

    /**
     * Get current user
     */
    public function getUser()
    {
        return Auth::user();
    }

    /**
     * Render the component based on auth state
     */
    public function render()
    {
        // Se estiver autenticado, mostrar a view de logout
        if ($this->isAuthenticated()) {
            return view('livewire.auth.logout-view');
        }
        
        // Se não estiver autenticado, mostrar a view de login
        return view('livewire.auth.login-view');
    }
}