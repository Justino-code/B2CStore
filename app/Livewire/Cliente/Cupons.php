<?php

namespace App\Livewire\Cliente;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Cupom;
use App\Models\Pedido;

class Cupons extends Component
{
    use WithPagination;

    public $tipoFiltro = 'ativos';
    public $busca = '';
    public $ordenarPor = 'validade_fim';
    public $ordenarDirecao = 'asc';
    public $porPagina = 12;

    public $cupomSelecionado = null;
    public $mostrarDetalhes = false;
    public $mostrarModalCopiar = false;

    public function aplicarFiltros()
    {
        $this->resetPage();
    }

    public function limparFiltros()
    {
        $this->tipoFiltro = 'ativos';
        $this->busca = '';
        $this->ordenarPor = 'validade_fim';
        $this->ordenarDirecao = 'asc';
        $this->resetPage();
    }

    public function ordenar($campo)
    {
        if ($this->ordenarPor === $campo) {
            $this->ordenarDirecao = $this->ordenarDirecao === 'asc' ? 'desc' : 'asc';
        } else {
            $this->ordenarPor = $campo;
            $this->ordenarDirecao = 'asc';
        }
    }

    public function verDetalhes($cupomId)
    {
        $this->cupomSelecionado = Cupom::find($cupomId);
        
        if ($this->cupomSelecionado) {
            // Verificar se o cliente usou este cupom
            $usadoPeloCliente = Pedido::where('id_usuario', Auth::id())
                ->where('id_cupom', $cupomId)
                ->exists();
            
            $this->cupomSelecionado->usado_pelo_cliente = $usadoPeloCliente;
            
            $this->mostrarDetalhes = true;
        }
    }

    public function fecharDetalhes()
    {
        $this->mostrarDetalhes = false;
        $this->cupomSelecionado = null;
    }

    public function copiarCodigo($codigo)
    {
        $this->dispatch('copiar-para-clipboard', texto: $codigo);
        $this->mostrarModalCopiar = true;
        
        // Esconder modal após 2 segundos
        sleep(2);
        $this->mostrarModalCopiar = false;
    }

    public function getCuponsQuery()
    {
        $query = Cupom::query();

        // Aplicar filtro de tipo
        if ($this->tipoFiltro === 'ativos') {
            $query->where('ativo', true);
        } elseif ($this->tipoFiltro === 'expirados') {
            $query->where(function($q) {
                $q->where('ativo', false)
                  ->orWhere(function($q2) {
                      $q2->where('validade_fim', '<', now())
                         ->whereNotNull('validade_fim');
                  });
            });
        } elseif ($this->tipoFiltro === 'usados') {
            // Cupons que o cliente já usou
            $cuponsUsados = Pedido::where('id_usuario', Auth::id())
                ->whereNotNull('id_cupom')
                ->pluck('id_cupom')
                ->unique()
                ->toArray();
            
            $query->whereIn('id_cupom', $cuponsUsados);
        }

        // Busca por código
        if ($this->busca) {
            $query->where('codigo', 'like', '%' . $this->busca . '%');
        }

        // Ordenação
        $query->orderBy($this->ordenarPor, $this->ordenarDirecao);

        return $query;
    }

    public function getCuponsProperty()
    {
        return $this->getCuponsQuery()->paginate($this->porPagina);
    }

    public function getEstatisticasProperty()
    {
        $totalCupons = Cupom::where('ativo', true)->count();
        
        $cuponsUsados = Pedido::where('id_usuario', Auth::id())
            ->whereNotNull('id_cupom')
            ->pluck('id_cupom')
            ->unique()
            ->count();

        $cuponsExpirados = Cupom::where(function($q) {
            $q->where('ativo', false)
              ->orWhere(function($q2) {
                  $q2->where('validade_fim', '<', now())
                     ->whereNotNull('validade_fim');
              });
        })->count();

        $cuponsProximosExpiracao = Cupom::where('ativo', true)
            ->whereNotNull('validade_fim')
            ->where('validade_fim', '>', now())
            ->where('validade_fim', '<=', now()->addDays(7))
            ->count();

        return [
            'total' => $totalCupons,
            'usados' => $cuponsUsados,
            'expirados' => $cuponsExpirados,
            'proximos_expiracao' => $cuponsProximosExpiracao,
        ];
    }

    public function cupomEstaValido($cupom)
    {
        if (!$cupom->ativo) {
            return false;
        }

        if ($cupom->usos_maximos && $cupom->usos_atual >= $cupom->usos_maximos) {
            return false;
        }

        $agora = now();
        if ($cupom->validade_inicio && $agora < $cupom->validade_inicio) {
            return false;
        }

        if ($cupom->validade_fim && $agora > $cupom->validade_fim) {
            return false;
        }

        return true;
    }

    public function cupomFoiUsadoPeloCliente($cupomId)
    {
        return Pedido::where('id_usuario', Auth::id())
            ->where('id_cupom', $cupomId)
            ->exists();
    }

    public function cupomProximoExpiracao($cupom)
    {
        if (!$cupom->validade_fim) {
            return false;
        }

        return now()->diffInDays($cupom->validade_fim) <= 7 && $cupom->validade_fim > now();
    }

    public function render()
    {
        return view('livewire.cliente.cupons', [
            'cupons' => $this->cupons,
            'estatisticas' => $this->estatisticas,
        ])->layout('components.layouts.cliente', [
            'titulo' => 'Meus Cupons - B2CStore'
        ]);
    }
}