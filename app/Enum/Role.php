<?php
namespace App\Enum;

enum Role: string {
    case ADMIN = 'admin';
    case CLIENTE = 'cliente';
    case OPERADOR = 'operador';
    case SUPORTE = 'suporte';
    case GERENTE = 'gerente';
}