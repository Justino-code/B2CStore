<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Traits\HasRole;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable, HasRole;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'telefone',
        'endereco',
        'avatar_url',
        'status',
        'remember_token',
        'role'
    ];

    protected $hidden = [
        'senha',
        'remember_token'
    ];

    protected $casts = [
        'email_verificado_em' => 'datetime',
        'ultimo_acesso' => 'datetime',
    ];

    // Relações
    public function carrinho()
    {
        return $this->hasOne(Carrinho::class, 'id_usuario', 'id_usuario');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_usuario', 'id_usuario');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_usuario', 'id_usuario');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'id_usuario', 'id_usuario');
    }

    public function pagamentos()
    {
        return $this->hasManyThrough(Pagamento::class, Pedido::class, 'id_usuario', 'id_pedido');
    }

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function quantidadeItensCarrinho(): int
    {
        return $this->carrinho?->itens()->count() ?? 0;
    }

    /**
     * Retorna o endereço como array para Angola
     */
    public function getEnderecoArrayAttribute()
    {
        if (empty($this->endereco)) {
            return null;
        }
        
        $parts = explode(',', $this->endereco);
        $parts = array_map('trim', $parts);
        
        // Para Angola: [rua, numero, bairro, municipio, provincia, complemento, referencia]
        $parts = array_pad($parts, 7, '');
        
        return [
            'rua' => $parts[0] ?? '',
            'numero' => $parts[1] ?? '',
            'bairro' => $parts[2] ?? '',
            'municipio' => $parts[3] ?? '',
            'provincia' => $parts[4] ?? '',
            'complemento' => $parts[5] ?? '',
            'referencia' => $parts[6] ?? '',
        ];
    }

    /**
     * Formata o endereço para exibição (Angola)
     */
    public function getEnderecoFormatadoAttribute()
    {
        $endereco = $this->endereco_array;
        
        if (!$endereco) {
            return 'Endereço não cadastrado';
        }
        
        $formatado = sprintf(
            '%s, %s - %s',
            $endereco['rua'],
            $endereco['numero'],
            $endereco['bairro']
        );
        
        if (!empty($endereco['complemento'])) {
            $formatado .= ', ' . $endereco['complemento'];
        }
        
        $formatado .= sprintf(
            ' - %s, %s',
            $endereco['municipio'],
            $endereco['provincia']
        );
        
        if (!empty($endereco['referencia'])) {
            $formatado .= ' (' . $endereco['referencia'] . ')';
        }
        
        return $formatado;
    }

    /**
     * Verifica se o usuário tem endereço cadastrado
     */
    public function getTemEnderecoAttribute()
    {
        return !empty($this->endereco) && count(explode(',', $this->endereco)) >= 5;
    }

    public function atualizarUltimoAcesso()
    {
        $this->ultimo_acesso = now();
    }

}
