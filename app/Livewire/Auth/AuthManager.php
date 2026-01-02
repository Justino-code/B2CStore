<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\LoginForm;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.guest', [
    'header' => 'Bem-vindo de volta',
    'description' => 'Entre na sua conta para continuar'
])]
class AuthManager extends Component
{
    public LoginForm $form;
    public bool $showPassword = false;
    public bool $isLoading = false;
    public ?string $logoutMessage = null;

    /**
     * Mount component
     */
    public function mount(): void
    {
        // Se já estiver autenticado, mostrar mensagem de boas-vindas
        if (Auth::check()) {
            $user = Auth::user();
            $this->logoutMessage = "Olá, {$user->name}! Você já está logado.";
        }
    }

    /**
     * Handle login
     */
    public function login(): void
    {
        try {
            $this->isLoading = true;
            $this->logoutMessage = null;
            
            $this->form->authenticate();
            
            session()->regenerate();
            
            $this->dispatch('logged-in');
            $this->dispatch('notify', 
                type: 'success', 
                message: 'Login realizado com sucesso!'
            );
            
            // Redirecionar após login bem-sucedido
            if(Auth::user()->isCliente){
                $this->redirect(route('cliente.dashboard'), navigate: true);
            
            }elseif(Auth::user()->isAdmin || Auth::user()->isGerente){
                 $this->redirect(route('admin.dashboard'), navigate: true);
            }
            else{
                $this->redirect(route('admin.perfil'), navigate: true);
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->isLoading = false;
            $this->dispatch('notify', 
                type: 'error', 
                message: 'Erro ao realizar login. Tente novamente.'
            );
            throw $e;
        } catch (\Throwable $e) {
            $this->isLoading = false;
            $this->dispatch('notify', 
                type: 'error', 
                message: 'Erro ao realizar login. Tente novamente.'
            );

            dd($e);
        }
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        $logout = new Logout();
        $logout();
        return redirect()->route('home'); 
    }

    /**
     * Toggle password visibility
     */
    public function togglePasswordVisibility(): void
    {
        $this->showPassword = !$this->showPassword;
    }

    /**
     * Clear form errors on input - CORRIGIDO
     */
    public function updated($property): void
    {
        // Limpar erros de validação quando o usuário começa a digitar
        if (str_starts_with($property, 'form.')) {
            $field = str_replace('form.', '', $property);
            
            // Remover erro específico do campo
            if ($this->getErrorBag()->has($field)) {
                $this->resetErrorBag($field);
            }
        }
    }

    /**
     * Clear specific field error
     */
    public function clearFieldError(string $field): void
    {
        $this->resetErrorBag($field);
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
     * Get all validation errors
     */
    public function getErrors(): array
    {
        return $this->getErrorBag()->toArray();
    }

    /**
     * Check if form has any errors
     */
    public function hasErrors(): bool
    {
        return $this->getErrorBag()->isNotEmpty();
    }

    /**
     * Render component based on auth state
     */
    public function render()
    {        
        // Se não estiver autenticado, mostrar a view de login
        return view('livewire.pages.auth.login');
    }
}