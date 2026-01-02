<?php

namespace App\Livewire\Admin\Categoria;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Categoria;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.admin')]
class Form extends Component
{
    use WithFileUploads;

    public $categoria;
    public $categoriaId;
    
    // Dados da categoria
    public $nome;
    public $descricao;
    public $imagem;
    public $imagemAtual;
    public $ordem;
    public $ativo = true;
    
    // UI State
    public $isEditing = false;

    public function mount($id = null)
    {
        $this->isEditing = !is_null($id);
        
        if ($this->isEditing) {
            $this->categoriaId = $id;
            $this->carregarCategoria();
        } else {
            $this->definirOrdem();
        }
    }

    protected function rules()
    {
        $rules = [
            'nome' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categorias', 'nome')->ignore($this->categoriaId, 'id_categoria')
            ],
            'descricao' => 'nullable|string',
            'imagem' => 'nullable|image|max:2048',
            'ordem' => 'required|integer|min:1',
            'ativo' => 'boolean',
        ];

        return $rules;
    }

    public function carregarCategoria()
    {
        $this->categoria = Categoria::findOrFail($this->categoriaId);
        
        $this->nome = $this->categoria->nome;
        $this->descricao = $this->categoria->descricao;
        $this->imagemAtual = $this->categoria->imagem_url;
        $this->ordem = $this->categoria->ordem;
        $this->ativo = $this->categoria->ativo;
    }

    public function definirOrdem()
    {
        $ultimaOrdem = Categoria::max('ordem');
        $this->ordem = $ultimaOrdem ? $ultimaOrdem + 1 : 1;
    }

    public function removerImagem()
    {
        $this->imagem = null;
        $this->imagemAtual = null;
    }

    #[On('confirm-remove-image')]
    public function confirmarRemoverImagem()
    {
        $this->removerImagem();
        
        $this->dispatch('notify', 
            type: 'success',
            message: 'Imagem removida com sucesso!'
        );
    }

    public function salvar()
    {
        $this->validate();

        try {
            \DB::beginTransaction();

            if ($this->isEditing) {
                $categoria = $this->categoria;
            } else {
                $categoria = new Categoria();
            }

            $categoria->fill([
                'nome' => $this->nome,
                'descricao' => $this->descricao,
                'ordem' => $this->ordem,
                'ativo' => $this->ativo,
            ]);

            // Upload da imagem
            if ($this->imagem) {
                // Remover imagem anterior se existir
                if ($this->isEditing && $categoria->imagem_url) {
                    Storage::delete($categoria->imagem_url);
                }
                
                $path = $this->imagem->store('categorias', 'public');
                $categoria->imagem_url = $path;
            } elseif (!$this->imagem && !$this->imagemAtual) {
                $categoria->imagem_url = null;
            }

            $categoria->save();

            // Ajustar ordem das outras categorias se necessário
            if ($this->isEditing) {
                $this->ajustarOrdem($categoria->id_categoria, $categoria->ordem);
            }

            \DB::commit();

            $this->dispatch('notify', 
                type: 'success',
                message: $this->isEditing 
                    ? 'Categoria atualizada com sucesso!' 
                    : 'Categoria criada com sucesso!'
            );

            return redirect()->route('admin.categorias.show', $categoria->id_categoria);

        } catch (\Exception $e) {
            \DB::rollBack();
            
            $this->dispatch('notify', 
                type: 'error',
                message: 'Erro ao salvar categoria: ' . $e->getMessage()
            );
        }
    }

    private function ajustarOrdem($categoriaId, $novaOrdem)
    {
        $categoriasParaAjustar = Categoria::where('id_categoria', '!=', $categoriaId)
            ->where('ordem', '>=', $novaOrdem)
            ->orderBy('ordem')
            ->get();

        $ordemAtual = $novaOrdem + 1;
        foreach ($categoriasParaAjustar as $categoria) {
            $categoria->update(['ordem' => $ordemAtual]);
            $ordemAtual++;
        }
    }

    public function render()
    {
        return view('livewire.admin.categoria.form');
    }
}