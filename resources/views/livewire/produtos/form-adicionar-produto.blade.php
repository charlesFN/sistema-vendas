<div>
    <div class="form-group">
        <label for="pesquisarProduto">Pesquisar</label>
        <div class="input-group mb-3">
            <input type="text" id="pesquisarProduto" class="form-control" wire:model.live="pesquisar_produto" placeholder="Digite o nomedo produto" autocomplete="off">
        </div>
    </div>
    <div class="d-flex">
        <div class="mx-auto">
            <div wire:loading>
                <div class="spinner-border"></div>
            </div>
        </div>
    </div>
    <div wire:loading.remove>
        <table class="table table-striped table-hover {{ $pesquisar_produto == '' ? 'd-none' : '' }}">
            <thead>
                <th>#</th>
                <th>Produto</th>
                <th>Preço (R$)</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @if ($produto != null)
                    <tr>
                        <td>
                            <img src="{{ url($produto->foto_produto) }}" style="width:100px;">
                        </td>
                        <td>{{ $produto->nome_produto }}</td>
                        <td>R$ {{ number_format($produto->valor_produto, 2, ',', '.') }}</td>
                        <td class="d-flex justify-content-between">
                            <button @if($qtd_produto == 1) disabled @endif type="button" class="btn btn-danger rounded-circle" wire:click="rmProduto">&minus;</button>
                            <span>{{ $qtd_produto }}</span>
                            <button @if($qtd_produto == $produto->quantidade_produto) disabled @endif type="button" class="btn btn-success rounded-circle" wire:click="addProduto">&plus;</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success" wire:click="selecionarProduto({{ $produto }})" data-dismiss="modal">Selecionar Produto</button>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="4">Nenhum produto encontrado.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
