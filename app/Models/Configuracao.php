<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Configuracao extends Model
{
    use HasFactory;

    protected $table = 'configuracoes';
    protected $primaryKey = 'id_configuracao';
    
    protected $fillable = [
        'chave', 
        'valor', 
        'tipo', 
        'grupo', 
        'descricao', 
        'editavel'
    ];

    protected $casts = [
        'editavel' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Busca uma configuração pelo nome
     */
    public static function buscar($chave, $default = null)
    {
        // Usar cache para melhor performance
        return Cache::remember('config_' . $chave, 3600, function () use ($chave, $default) {
            $config = static::where('chave', $chave)->first();
            
            if (!$config) {
                return $default;
            }

            // Converter valor conforme o tipo
            return match($config->tipo) {
                'integer' => (int) $config->valor,
                'boolean' => (bool) $config->valor,
                'float' => (float) $config->valor,
                'json' => json_decode($config->valor, true),
                'array' => explode(',', $config->valor),
                default => $config->valor,
            };
        });
    }

    /**
     * Salva uma configuração
     */
    public static function salvar($chave, $valor, $tipo = 'string', $grupo = 'geral', $descricao = null, $editavel = true)
    {
        // Limpar cache
        Cache::forget('config_' . $chave);

        $config = static::where('chave', $chave)->first();

        if ($config) {
            // Atualizar configuração existente
            if (!$config->editavel) {
                throw new \Exception("Configuração '{$chave}' não é editável.");
            }

            // Converter valor para string conforme o tipo
            $valorFormatado = match($tipo) {
                'boolean' => $valor ? '1' : '0',
                'json' => json_encode($valor),
                'array' => is_array($valor) ? implode(',', $valor) : $valor,
                default => (string) $valor,
            };

            $config->update([
                'valor' => $valorFormatado,
                'tipo' => $tipo,
                'grupo' => $grupo,
                'descricao' => $descricao ?? $config->descricao,
                'editavel' => $editavel,
            ]);
        } else {
            // Criar nova configuração
            $valorFormatado = match($tipo) {
                'boolean' => $valor ? '1' : '0',
                'json' => json_encode($valor),
                'array' => is_array($valor) ? implode(',', $valor) : $valor,
                default => (string) $valor,
            };

            $config = static::create([
                'chave' => $chave,
                'valor' => $valorFormatado,
                'tipo' => $tipo,
                'grupo' => $grupo,
                'descricao' => $descricao,
                'editavel' => $editavel,
            ]);
        }

        return $config;
    }

    /**
     * Busca todas as configurações de um grupo
     */
    public static function buscarGrupo($grupo)
    {
        return Cache::remember('config_grupo_' . $grupo, 3600, function () use ($grupo) {
            $configs = static::where('grupo', $grupo)->get();
            
            $resultado = [];
            foreach ($configs as $config) {
                $resultado[$config->chave] = match($config->tipo) {
                    'integer' => (int) $config->valor,
                    'boolean' => (bool) $config->valor,
                    'float' => (float) $config->valor,
                    'json' => json_decode($config->valor, true),
                    'array' => explode(',', $config->valor),
                    default => $config->valor,
                };
            }
            
            return $resultado;
        });
    }

    /**
     * Verifica se o sistema está em manutenção
     */
    public static function emManutencao()
    {
        return static::buscar('manutencao', false);
    }

    /**
     * Obtém a versão do sistema
     */
    public static function versaoSistema()
    {
        return static::buscar('versao_sistema', '1.0.0');
    }

    /**
     * Limpa cache de configurações
     */
    public static function limparCache()
    {
        $configs = static::all();
        foreach ($configs as $config) {
            Cache::forget('config_' . $config->chave);
        }
        Cache::forget('config_grupo_*');
    }
}