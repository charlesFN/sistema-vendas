<?php

namespace App\Livewire\Produtos;

use Livewire\Component;
use App\Models\Produto;

class FormAdicionarProduto extends Component
{
    public $produto;
    public $pesquisar_produto;
    public $qtd_produto = 1;

    public function rmProduto()
    {
        $this->qtd_produto--;
    }

    public function addProduto()
    {
        $this->qtd_produto++;
    }

    public function selecionarProduto($produto)
    {
        $compra = [
            'nome_produto' => $produto['nome_produto'],
            'quantidade' => $this->qtd_produto,
            'valor_compra' => $produto['valor_produto'] * $this->qtd_produto
        ];
        $this->dispatch('produtoListener', $compra);
        $this->qtd_produto = 1;
    }

    public function render()
    {
        if ($this->pesquisar_produto != '') {
            $this->produto = Produto::where('nome_produto', 'like', '%'. $this->pesquisar_produto .'%')->first();
        }

        return view('livewire.produtos.form-adicionar-produto', ['produto' => $this->produto]);
    }
}
