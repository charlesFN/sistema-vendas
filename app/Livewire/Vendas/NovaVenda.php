<?php

namespace App\Livewire\Vendas;

use App\Models\Venda;
use App\Models\Produto;
use Livewire\Component;

class NovaVenda extends Component
{
    protected $listeners = ['produtoListener'];

    public $produtos = [];
    public $pesquisar_produto;
    public $total_produtos = 0;
    public $valor_total = 0;

    public function produtoListener($compra)
    {
        array_push($this->produtos, $compra);

        $this->total_produtos = $this->total_produtos + $compra['quantidade'];
        $this->valor_total = $this->valor_total + $compra['valor_compra'];
    }

    public function removerProduto($index)
    {
        $quantidade = $this->produtos[$index]['quantidade'];
        $valor_compra = $this->produtos[$index]['valor_compra'];

        $this->total_produtos = $this->total_produtos - $quantidade;
        $this->valor_total = $this->valor_total - $valor_compra;

        array_splice($this->produtos, $index, 1);
    }

    public function render()
    {
        return view('livewire.vendas.nova-venda', ['produtos' => $this->produtos]);
    }

    public function save()
    {
        $produtos = array();
        $qtd_produtos = array();

        dd($this->produtos);

        foreach ($this->produtos as $produto) {
            array_push($produtos, $produto['nome_produto']);
            array_push($qtd_produtos, $produto['quantidade']);

            $produto_cadastrado = Produto::where('nome_produto', $produto['nome_produto'])->first();
            $estoque_atualizado = $produto_cadastrado->quantidade_produto - $produto['quantidade'];

            $produto_cadastrado->update(['quantidade_produto' => $estoque_atualizado]);
        }

        $data = [
            'produtos' => $produtos,
            'qtd_produtos' => $qtd_produtos,
            'qtd_total_produtos' => $this->total_produtos,
            'valor_total_venda' => $this->valor_total
        ];

        Venda::create($data);

        return redirect()->route('venda.index')->with('success', 'Venda registrada com sucesso!');
    }
}
