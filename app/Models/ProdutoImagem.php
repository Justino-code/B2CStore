<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoImagem extends Model
{
    use HasFactory;

    protected $table = 'produto_imagens';
    protected $primaryKey = 'id_imagem';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'id_produto',
        'url_imagem',
        'ordem',
        'principal'
    ];

    protected $casts = [
        'ordem' => 'integer',
        'principal' => 'boolean',
    ];

    // Relações
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto', 'id_produto');
    }

    // Scopes
    public function scopePrincipais($query)
    {
        return $query->where('principal', true);
    }

    public function scopeOrdenadas($query)
    {
        return $query->orderBy('ordem');
    }
}
