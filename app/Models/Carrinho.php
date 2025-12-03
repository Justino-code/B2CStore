<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    use HasFactory;

    protected $table = 'carrinhos';
    protected $primaryKey = 'id_carrinho';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'id_usuario'
    ];

    // Relações
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function itens()
    {
        return $this->hasMany(CarrinhoItem::class, 'id_carrinho', 'id_carrinho');
    }

    // Métodos de ajuda
    public function totalItens()
    {
        return $this->itens()->sum('quantidade');
    }

    public function subtotal()
    {
        return $this->itens->sum(function ($item) {
            return $item->preco_unitario * $item->quantidade;
        });
    }

    public function vazio()
    {
        return $this->itens()->count() === 0;
    }

    public function temProduto($produtoId)
    {
        return $this->itens()->where('id_produto', $produtoId)->exists();
    }

    public function quantidadeProduto($produtoId)
    {
        $item = $this->itens()->where('id_produto', $produtoId)->first();
        return $item ? $item->quantidade : 0;
    }
}
