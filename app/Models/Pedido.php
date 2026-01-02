<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'id_usuario',
        'id_cupom',
        'codigo_pedido',
        'total',
        'custo_envio',
        'valor_desconto',
        'status',
        'endereco_entrega',
        'metodo_envio',
        'data_entrega',
        'observacoes'
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'custo_envio' => 'decimal:2',
        'valor_desconto' => 'decimal:2',
        'data_entrega' => 'datetime',
    ];

    /**
     * Eventos do model
     */
    protected static function booted()
    {
        static::creating(function (Pedido $pedido) {
            if (empty($pedido->codigo_pedido)) {
                $pedido->codigo_pedido = self::gerarCodigoUnico();
            }
        });
    }

    /**
     * Gera um código único para o pedido
     */
    private static function gerarCodigoUnico(): string
    {
        do {
            $codigo = 'PED-' . strtoupper(Str::random(10));
        } while (self::where('codigo_pedido', $codigo)->exists());

        return $codigo;
    }

    // ─────────────────────────────
    // Relações
    // ─────────────────────────────

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function cupom()
    {
        return $this->belongsTo(Cupom::class, 'id_cupom', 'id_cupom');
    }

    public function itens()
    {
        return $this->hasMany(PedidoItem::class, 'id_pedido', 'id_pedido');
    }

    public function pagamento()
    {
        return $this->hasOne(Pagamento::class, 'id_pedido', 'id_pedido');
    }

    // ─────────────────────────────
    // Métodos de ajuda
    // ─────────────────────────────

    public function subtotal()
    {
        return $this->total - $this->custo_envio + $this->valor_desconto;
    }

    public function totalProdutos()
    {
        return $this->itens->sum('quantidade');
    }

    public function podeSerCancelado()
    {
        return in_array($this->status, ['pendente', 'pago', 'processando']);
    }

    public function estaPago()
    {
        return in_array($this->status, ['pago', 'processando', 'enviado', 'entregue']);
    }

    public function estaEntregue()
    {
        return $this->status === 'entregue';
    }

    // ─────────────────────────────
    // Scopes
    // ─────────────────────────────

    public function scopeDoUsuario($query, $usuarioId)
    {
        return $query->where('id_usuario', $usuarioId);
    }

    public function scopePorStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePagos($query)
    {
        return $query->whereIn('status', ['pago', 'processando', 'enviado', 'entregue']);
    }

    public function scopeRecentes($query, $dias = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($dias));
    }
}
