<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $primaryKey = 'id_review';

    protected $fillable = [
        'id_produto',
        'id_usuario',
        'rating',
        'comentario',
        'aprovado'
    ];

    protected $casts = [
        'rating' => 'integer',
        'aprovado' => 'boolean',
    ];

    // Relações
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto', 'id_produto');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    // Métodos de ajuda
    public function aprovar()
    {
        $this->aprovado = true;
        $this->save();
    }

    public function reprovar()
    {
        $this->aprovado = false;
        $this->save();
    }

    // Scopes
    public function scopeAprovados($query)
    {
        return $query->where('aprovado', true);
    }

    public function scopePorRating($query, $minRating = 4)
    {
        return $query->where('rating', '>=', $minRating);
    }

    public function scopeRecentes($query, $limite = 10)
    {
        return $query->orderBy('criado_em', 'desc')->limit($limite);
    }
}
