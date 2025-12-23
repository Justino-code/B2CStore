<?php
// app/Models/Banner.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Banner extends Model
{
    protected $primaryKey = 'id_banner';
    protected $table = 'banners';
    
    protected $fillable = [
        'titulo',
        'subtitulo',
        'descricao',
        'imagem',
        'link',
        'texto_botao',
        'ordem',
        'ativo',
        'tipo',
        'inicio_exibicao',
        'fim_exibicao'
    ];
    
    protected $casts = [
        'ativo' => 'boolean',
        'ordem' => 'integer',
        'inicio_exibicao' => 'date',
        'fim_exibicao' => 'date'
    ];
    
    // Scopes
    public function scopeAtivo(Builder $query)
    {
        return $query->where('ativo', true)
                    ->where(function($q) {
                        $q->whereNull('inicio_exibicao')
                          ->orWhere('inicio_exibicao', '<=', now());
                    })
                    ->where(function($q) {
                        $q->whereNull('fim_exibicao')
                          ->orWhere('fim_exibicao', '>=', now());
                    });
    }
    
    public function scopeTipo(Builder $query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }
    
    public function scopePrincipal(Builder $query)
    {
        return $query->tipo('principal');
    }
}