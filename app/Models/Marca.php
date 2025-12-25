<?php
// app/Models/Marca.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Marca extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_marca';
    protected $table = 'marcas';
    
    protected $fillable = [
        'nome',
        'slug',
        'descricao',
        'logo_url',
        'website',
        'ordem',
        'ativo',
        'meta_title',
        'meta_description'
    ];
    
    protected $casts = [
        'ativo' => 'boolean',
        'ordem' => 'integer'
    ];
    
    // Scopes
    public function scopeAtivo(Builder $query)
    {
        return $query->where('ativo', true);
    }
    
    public function scopeOrdenado(Builder $query)
    {
        return $query->orderBy('ordem')->orderBy('nome');
    }
    
    // Relacionamentos
    public function produtos()
    {
        return $this->hasMany(Produto::class, 'id_marca');
    }
    
    // Accessors
    public function getProdutosAtivosAttribute()
    {
        return $this->produtos()->ativo()->get();
    }
    
    public function getTotalProdutosAttribute()
    {
        return $this->produtos()->ativo()->count();
    }
    
    // Mutators
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = $value ?: Str::slug($this->nome);
    }
}