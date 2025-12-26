<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\RegisterForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.guest', [
    'header' => 'Criar Nova Conta',
    'description' => 'Preencha os dados abaixo para se registrar'
])]
class RegisterManager extends Component
{
    public RegisterForm $form;
    public bool $showPassword = false;
    public bool $showConfirmPassword = false;
    public bool $isLoading = false;
    public ?string $successMessage = null;

    /**
     * Mount component
     */
    public function mount(): void
    {
        if (Auth::check()) {
            $this->redirect(route('dashboard'), navigate: true);
        }
    }

    /**
     * Handle registration
     */
    public function register(): void
    {
        try {
            $this->isLoading = true;
            $this->successMessage = null;

            $usuario = $this->form->register();
            
            Auth::login($usuario);

            session()->regenerate();

            $this->dispatch('registered');
            $this->dispatch('notify',
                type: 'success',
                message: 'Conta criada com sucesso'
            );
            
            // Redirecionar após registro
            $this->redirect(route('perfil'), navigate: true);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->isLoading = false;
            throw $e;
        } catch (\Exception $e) {
            $this->isLoading = false;
            $this->dispatch('notify',
                type: 'info',
                message: 'Erro ao criar conta. Tente novamente.'
            );
            $this->addError('general', 'Erro ao criar conta. Tente novamente.');
        }
    }

    /**
     * Toggle password visibility
     */
    public function togglePasswordVisibility(string $field = 'senha'): void
    {
        if ($field === 'senha') {
            $this->showPassword = !$this->showPassword;
        } else {
            $this->showConfirmPassword = !$this->showConfirmPassword;
        }
    }

    /**
     * Clear form errors on input
     */
    public function updated($property): void
    {
        if (str_starts_with($property, 'form.')) {
            $field = str_replace('form.', '', $property);
            
            if ($this->getErrorBag()->has($field)) {
                $this->resetErrorBag($field);
            }
        }
    }

    /**
     * Check if passwords match
     */
    public function passwordsMatch(): bool
    {
        return $this->form->senha === $this->form->senha_confirmation;
    }

    public function getPasswordsMatchProperty(): bool
    {
        return $this->form->senha === $this->form->senha_confirmation;
    }

    /**
     * Get password strength indicator
     */
    public function getPasswordStrength(): array
    {
        $senha = $this->form->senha;
        $strength = 0;
        $feedback = [];

        if (strlen($senha) >= 8) $strength += 25;
        if (preg_match('/[A-Z]/', $senha)) $strength += 25;
        if (preg_match('/[a-z]/', $senha)) $strength += 25;
        if (preg_match('/[0-9]/', $senha)) $strength += 25;
        if (preg_match('/[^A-Za-z0-9]/', $senha)) $strength += 25;

        $strength = min($strength, 100);

        // Feedback
        if (strlen($senha) < 8) {
            $feedback[] = 'Mínimo 8 caracteres';
        }
        if (!preg_match('/[A-Z]/', $senha)) {
            $feedback[] = 'Adicione uma letra maiúscula';
        }
        if (!preg_match('/[0-9]/', $senha)) {
            $feedback[] = 'Adicione um número';
        }

        return [
            'strength' => $strength,
            'feedback' => $feedback,
            'color' => $this->getStrengthColor($strength),
        ];
    }

    /**
     * Get color based on password strength
     */
    private function getStrengthColor(int $strength): string
    {
        if ($strength < 25) return 'red';
        if ($strength < 50) return 'orange';
        if ($strength < 75) return 'yellow';
        return 'green';
    }

    /**
     * Render component
     */
    public function render()
    {
        return view('livewire.pages.auth.register');
    }
}