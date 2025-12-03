<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupom extends Model
{
    use HasFactory;

    protected $table = 'cupons';
    protected $primaryKey = 'id_cupom';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'codigo',
        'tipo_desconto',
        'valor_desconto',
        'valor_minimo',
        'usos_maximos',
        'usos_atual',
        'validade_inicio',
        'validade_fim',
        'ativo'
    ];

    protected $casts = [
        'valor_desconto' => 'decimal:2',
        'valor_minimo' => 'decimal:2',
        'usos_maximos' => 'integer',
        'usos_atual' => 'integer',
        'ativo' => 'boolean',
        'validade_inicio' => 'datetime',
        'validade_fim' => 'datetime',
    ];

    // Relações
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_cupom', 'id_cupom');
    }

    // Métodos de ajuda
    public function valido()
    {
        if (!$this->ativo) {
            return false;
        }

        if ($this->usos_maximos && $this->usos_atual >= $this->usos_maximos) {
            return false;
        }

        $agora = now();
        if ($this->validade_inicio && $agora < $this->validade_inicio) {
            return false;
        }

        if ($this->validade_fim && $agora > $this->validade_fim) {
            return false;
        }

        return true;
    }

    public function calcularDesconto($valorTotal)
    {
        if (!$this->valido() || $valorTotal < $this->valor_minimo) {
            return 0;
        }

        if ($this->tipo_desconto === 'percentual') {
            return ($valorTotal * $this->valor_desconto) / 100;
        }

        return min($this->valor_desconto, $valorTotal);
    }

    public function usar()
    {
        $this->increment('usos_atual');
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeValidos($query)
    {
        $agora = now();
        return $query->where('ativo', true)
                    ->where(function($q) use ($agora) {
                        $q->whereNull('validade_fim')
                          ->orWhere('validade_fim', '>=', $agora);
                    })
                    ->where(function($q) use ($agora) {
                        $q->whereNull('validade_inicio')
                          ->orWhere('validade_inicio', '<=', $agora);
                    })
                    ->where(function($q) {
                        $q->whereNull('usos_maximos')
                          ->orWhereColumn('usos_atual', '<', 'usos_maximos');
                    });
    }
}
