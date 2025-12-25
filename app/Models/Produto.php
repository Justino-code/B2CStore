<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';
    protected $primaryKey = 'id_produto';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'id_categoria',
         'id_marca',
        'nome',
        'descricao',
        'preco',
        'preco_promocional',
        'sku',
        'estoque',
        'peso',
        'dimensoes',
        'slug',
        'ativo',
        'destaque'
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'preco_promocional' => 'decimal:2',
        'peso' => 'decimal:2',
        'estoque' => 'integer',
        'ativo' => 'boolean',
        'destaque' => 'boolean',
    ];

    // Relações
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }

    public function imagens()
    {
        return $this->hasMany(ProdutoImagem::class, 'id_produto', 'id_produto')->orderBy('ordem');
    }

    public function imagemPrincipal()
    {
        return $this->hasOne(ProdutoImagem::class, 'id_produto', 'id_produto')->where('principal', true);
    }

    public function carrinhoItens()
    {
        return $this->hasMany(CarrinhoItem::class, 'id_produto', 'id_produto');
    }

    public function pedidoItens()
    {
        return $this->hasMany(PedidoItem::class, 'id_produto', 'id_produto');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_produto', 'id_produto')->where('aprovado', true);
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'id_produto', 'id_produto');
    }

    // Métodos de ajuda
    public function precoAtual()
    {
        return $this->preco_promocional ?: $this->preco;
    }

    public function temDesconto()
    {
        return !is_null($this->preco_promocional) && $this->preco_promocional < $this->preco;
    }

    public function percentualDesconto()
    {
        if (!$this->temDesconto()) {
            return 0;
        }

        return round((($this->preco - $this->preco_promocional) / $this->preco) * 100);
    }

    public function emEstoque()
    {
        return $this->estoque > 0;
    }

    public function baixoEstoque($limite = 5)
    {
        return $this->estoque <= $limite && $this->estoque > 0;
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeDestaque($query)
    {
        return $query->where('destaque', true);
    }

    public function scopeEmPromocao($query)
    {
        return $query->whereNotNull('preco_promocional')->whereColumn('preco_promocional', '<', 'preco');
    }

    public function scopeComEstoque($query)
    {
        return $query->where('estoque', '>', 0);
    }

    public function scopePorCategoria($query, $categoriaId)
    {
        return $query->where('id_categoria', $categoriaId);
    }

    public function scopeBuscar($query, $termo)
    {
        return $query->where('nome', 'LIKE', "%{$termo}%")
                    ->orWhere('descricao', 'LIKE', "%{$termo}%")
                    ->orWhere('sku', 'LIKE', "%{$termo}%");
    }

     public static function boot()
    {
        parent::boot();

        static::saving(function ($produto) {
            if (!$produto->slug) {
                $slug = Str::slug($produto->nome, '-');
                $slug = $slug . '-' . uniqid(); 
                $produto->slug = $slug;
            }
        });
    }
}
