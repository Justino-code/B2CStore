<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;

    protected $table = 'pagamentos';
    protected $primaryKey = 'id_pagamento';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'id_pedido',
        'metodo',
        'status',
        'valor',
        'transacao_id',
        'detalhes'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'detalhes' => 'array',
    ];

    // Relações
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }

    // Métodos de ajuda
    public function bemSucedido()
    {
        return $this->status === 'pago';
    }

    public function falhou()
    {
        return $this->status === 'falhou';
    }

    public function pendente()
    {
        return $this->status === 'pendente';
    }

    // Scopes
    public function scopeBemSucedidos($query)
    {
        return $query->where('status', 'pago');
    }

    public function scopePorMetodo($query, $metodo)
    {
        return $query->where('metodo', $metodo);
    }
}
