<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrinhoItem extends Model
{
    use HasFactory;

    protected $table = 'carrinho_itens';
    protected $primaryKey = 'id_item_carrinho';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'id_carrinho',
        'id_produto',
        'quantidade',
        'preco_unitario'
    ];

    protected $casts = [
        'quantidade' => 'integer',
        'preco_unitario' => 'decimal:2',
    ];

    // Relações
    public function carrinho()
    {
        return $this->belongsTo(Carrinho::class, 'id_carrinho', 'id_carrinho');
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto', 'id_produto')->with('imagemPrincipal');
    }

    // Métodos de ajuda
    public function subtotal()
    {
        return $this->preco_unitario * $this->quantidade;
    }

    public function aumentarQuantidade($quantidade = 1)
    {
        $this->quantidade += $quantidade;
        $this->save();
    }

    public function diminuirQuantidade($quantidade = 1)
    {
        $this->quantidade = max(1, $this->quantidade - $quantidade);
        $this->save();
    }
}
