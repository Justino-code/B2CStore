<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nome',
        'descricao',
        'imagem_url',
        'slug',
        'ordem',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    // Adicionar validação para garantir nome único e um slug
    public static function boot()
    {
        parent::boot();

        static::saving(function ($categoria) {
            // Verificar se já existe uma categoria com o mesmo nome (ignorando esta)
            $existente = Categoria::where('nome', $categoria->nome)
                ->where('id_categoria', '!=', $categoria->id_categoria)
                ->first();

            if ($existente) {
                throw new \Exception("Já existe uma categoria com o nome '{$categoria->nome}'");
            }

            if (!$categoria->slug) {
                $slug = Str::slug($categoria->nome, '-');
                $slug = $slug . '-' . uniqid(); 
                $categoria->slug = $slug;
            }
        });
    }

    // Relações
    public function produtos()
    {
        return $this->hasMany(Produto::class, 'id_categoria', 'id_categoria');
    }

    public function produtosAtivos()
    {
        return $this->hasMany(Produto::class, 'id_categoria', 'id_categoria')->where('ativo', true);
    }

    // Scopes
    public function scopeAtivas($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenadas($query)
    {
        return $query->orderBy('ordem')->orderBy('nome');
    }
}
