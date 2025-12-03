<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'telefone',
        'endereco',
        'avatar_url',
        'remember_token',
        'role'
    ];

    protected $hidden = [
        'senha',
        'remember_token'
    ];

    protected $casts = [
        'email_verificado_em' => 'datetime',
    ];

    // Relações
    public function carrinho()
    {
        return $this->hasOne(Carrinho::class, 'id_usuario', 'id_usuario');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_usuario', 'id_usuario');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_usuario', 'id_usuario');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'id_usuario', 'id_usuario');
    }

    public function pagamentos()
    {
        return $this->hasManyThrough(Pagamento::class, Pedido::class, 'id_usuario', 'id_pedido');
    }

    // Métodos de ajuda
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function getAuthPassword()
    {
        return $this->senha;
    }
}
