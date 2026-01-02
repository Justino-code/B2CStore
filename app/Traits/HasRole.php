<?php
namespace App\Traits;

use App\Enum\Role;

trait HasRole
{
    public function getIsAdminAttribute() : bool {
        return $this->role === Role::ADMIN->value;
    }

    public function getIsOperadorAttribute(): bool{
        return $this->role === Role::OPERADOR->value;
    }

    public function getIsGerenteAttribute() : bool {
        return $this->role === Role::GERENTE->value;
    }

    public function getIsSuporteAttribute() : bool {
        return $this->role === Role::SUPORTE->value;
    }

    public function getIsClienteAttribute(): bool{
        return $this->role === Role::CLIENTE->value;
    }

    public function hasRole(Role|string $role) : bool {
        return $this->role === ($role instanceof Role ? $role->value : $role);
    }
}
