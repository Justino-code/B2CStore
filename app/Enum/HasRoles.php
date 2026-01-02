<?php
namespace App\Enum;

enum HasRoles: string {
    case ADMIN = 'admin';
    case OPERADOR = 'operador';
    case SUPORTE = 'suporte';
    case Gerente = 'gerente';
}