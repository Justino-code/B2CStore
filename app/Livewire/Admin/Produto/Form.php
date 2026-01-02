<?php

namespace App\Livewire\Admin\Produto;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\ProdutoImagem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On; 

use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Form extends Component
{
    use WithFileUploads;

    public $produto;
    public $produtoId;
    
    // Dados do produto
    public $id_categoria;
    public $nome;
    public $descricao;
    public $preco;
    public $preco_promocional;
    public $sku;
    public $estoque = 0;
    public $peso;
    public $dimensoes;
    public $slug;
    public $ativo = true;
    public $destaque = false;
    
    // Imagens
    public $imagens = [];
    public $imagensExistentes = [];
    public $imagensParaRemover = [];
    
    // UI State
    public $isEditing = false;

    public function mount($id = null)
    {
        $this->isEditing = !is_null($id);
        
        if ($this->isEditing) {
            $this->produtoId = $id;
            $this->carregarProduto();
        } else {
            $this->gerarSlug();
            $this->gerarSKU();
        }
    }

    protected function rules()
    {
        $rules = [
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'nome' => 'required|string|max:200',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'preco_promocional' => 'nullable|numeric|lt:preco',
            'sku' => [
                'required',
                'string',
                'max:100',
                Rule::unique('produtos', 'sku')->ignore($this->produtoId, 'id_produto')
            ],
            'estoque' => 'required|integer|min:0',
            'peso' => 'nullable|numeric|min:0',
            'dimensoes' => 'nullable|string|max:100',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('produtos', 'slug')->ignore($this->produtoId, 'id_produto')
            ],
            'ativo' => 'boolean',
            'destaque' => 'boolean',
            'imagens' => 'nullable|array|max:10',
            'imagens.*' => 'image|max:2048',
        ];

        return $rules;
    }

    public function carregarProduto()
    {
        $this->produto = Produto::with('imagens')->findOrFail($this->produtoId);
        
        $this->id_categoria = $this->produto->id_categoria;
        $this->nome = $this->produto->nome;
        $this->descricao = $this->produto->descricao;
        $this->preco = $this->produto->preco;
        $this->preco_promocional = $this->produto->preco_promocional;
        $this->sku = $this->produto->sku;
        $this->estoque = $this->produto->estoque;
        $this->peso = $this->produto->peso;
        $this->dimensoes = $this->produto->dimensoes;
        $this->slug = $this->produto->slug;
        $this->ativo = $this->produto->ativo;
        $this->destaque = $this->produto->destaque;
        
        $this->imagensExistentes = $this->produto->imagens->map(function($imagem) {
            return [
                'id' => $imagem->id_imagem,
                'url' => $imagem->url_imagem,
                'principal' => $imagem->principal,
                'ordem' => $imagem->ordem
            ];
        })->toArray();
    }

    public function updatedNome($value)
    {
        if (!$this->isEditing || empty($this->slug)) {
            $this->gerarSlug();
        }
    }

    public function gerarSlug()
    {
        if (!empty($this->nome)) {
            $this->slug = Str::slug($this->nome);
        }
    }

    public function gerarSKU()
    {
        if (empty($this->sku)) {
            $prefix = strtoupper(Str::random(3));
            $number = str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $this->sku = "SKU-{$prefix}{$number}";
            
            // Mostrar notificação
            $this->dispatch('notify', 
                type: 'success',
                message: 'SKU gerado automaticamente!'
            );
        }
    }

    public function definirImagemPrincipal($index)
    {
        // Reset todas as imagens existentes
        foreach ($this->imagensExistentes as &$imagem) {
            $imagem['principal'] = false;
        }
        
        // Definir nova imagem principal
        $this->imagensExistentes[$index]['principal'] = true;
        
        // Mostrar notificação
        $this->dispatch('notify', 
            type: 'success',
            message: 'Imagem principal definida!'
        );
    }

    public function removerImagem($id)
    {
        // Usar confirmação personalizada
        $this->dispatch('confirm', 
            title: 'Remover Imagem',
            text: 'Tem certeza que deseja remover esta imagem?',
            icon: 'warning',
            confirmButtonText: 'Sim, remover',
            cancelButtonText: 'Cancelar',
            method: 'remover-imagem',
            params: [(int)$id]
        );
    }

    #[On('remover-imagem')] 
    public function removerImagemConfirmado($id)
    {
        $this->imagensParaRemover[] = $id;
        
        $this->imagensExistentes = array_filter($this->imagensExistentes, function($imagem) use ($id) {
            return $imagem['id'] != $id;
        });
        
        // Mostrar notificação
        $this->dispatch('notify', 
            type: 'success',
            message: 'Imagem removida!'
        );
    }

    public function removerImagemTemporaria($index)
    {
        // Usar confirmação personalizada
        $this->dispatch('confirm', 
            title: 'Remover Imagem',
            text: 'Tem certeza que deseja remover esta imagem?',
            icon: 'warning',
            confirmButtonText: 'Sim, remover',
            cancelButtonText: 'Cancelar',
            method: 'remover-imagem-temp',
            params: [$index]
        );
    }

    #[On('remover-imagem-temp')] 
    public function removerImagemTemporariaConfirmado($index)
    {
        if (isset($this->imagens[$index])) {
            unset($this->imagens[$index]);
            $this->imagens = array_values($this->imagens); // Reindexar array
            
            // Mostrar notificação
            $this->dispatch('notify', 
                type: 'success',
                message: 'Imagem temporária removida!'
            );
        }
    }

    public function salvar()
    {
        $this->validate();

        try {
            \DB::beginTransaction();

            if ($this->isEditing) {
                $produto = $this->produto;
            } else {
                $produto = new Produto();
            }

            $produto->fill([
                'id_categoria' => $this->id_categoria,
                'nome' => $this->nome,
                'descricao' => $this->descricao,
                'preco' => $this->preco,
                'preco_promocional' => $this->preco_promocional,
                'sku' => $this->sku,
                'estoque' => $this->estoque,
                'peso' => $this->peso,
                'dimensoes' => $this->dimensoes,
                'slug' => $this->slug,
                'ativo' => $this->ativo,
                'destaque' => $this->destaque,
            ]);

            $produto->save();

            // Remover imagens marcadas para remoção
            if (!empty($this->imagensParaRemover)) {
                ProdutoImagem::whereIn('id_imagem', $this->imagensParaRemover)->delete();
            }

            // Atualizar ordem e status das imagens existentes
            foreach ($this->imagensExistentes as $index => $imagemData) {
                ProdutoImagem::where('id_imagem', $imagemData['id'])
                    ->update([
                        'ordem' => $index,
                        'principal' => $imagemData['principal']
                    ]);
            }

            // Salvar novas imagens
            if (!empty($this->imagens)) {
                $ordemInicial = count($this->imagensExistentes);
                
                foreach ($this->imagens as $index => $imagem) {
                    $path = $imagem->store("produtos/{$produto->id_produto}", 'public');
                    
                    ProdutoImagem::create([
                        'id_produto' => $produto->id_produto,
                        'url_imagem' => $path,
                        'ordem' => $ordemInicial + $index,
                        'principal' => ($ordemInicial + $index === 0 && empty($this->imagensExistentes))
                    ]);
                }
            }

            \DB::commit();

            // Notificação de sucesso
            $this->dispatch('notify', 
                type: 'success',
                message: $this->isEditing 
                    ? 'Produto atualizado com sucesso!' 
                    : 'Produto criado com sucesso!',
                options: ['duration' => 4000]
            );

            return redirect()->route('admin.produtos.show', $produto->id_produto);

        } catch (\Exception $e) {
            \DB::rollBack();
            
            // Notificação de erro
            $this->dispatch('notify', 
                type: 'error',
                message: 'Erro ao salvar produto.',
                options: ['duration' => 5000]
            );
        }
    }

    public function render()
    {
        $categorias = Categoria::where('ativo', true)->orderBy('nome')->get();

        return view('livewire.admin.produto.form', [
            'categorias' => $categorias,
        ]);
    }
}