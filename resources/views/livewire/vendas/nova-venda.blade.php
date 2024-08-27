<div>
    <div class="card">
        <form action="" method="post">
            <div class="card-body">
                <table class="table table-hover table-stripped">
                    <thead>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Valor (R$)</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($produtos as $index => $produto)
                            <tr>
                                <td>{{ $produto['nome_produto'] }}</td>
                                <td>{{ $produto['quantidade'] }}</td>
                                <td>R$ {{ number_format($produto['valor_compra'], 2, ',', '.') }}</td>
                                <td><button type="button" class="btn btn-danger" wire:click="removerProduto({{ $index }})">Remover Produto</button></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Nenhum produto selecionado</td>
                            </tr>
                        @endforelse

                        <table class="table table-hover table-stripped">
                            <hr>
                            <thead>
                                <th>Total Produtos</th>
                                <th>Valor Total</th>
                            </thead>
                            <tbody>
                                <td>{{ $total_produtos }}</td>
                                <td>R$ {{ number_format($valor_total, 2, ',', '.') }}</td>
                            </tbody>
                        </table>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-around">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#adicionarProduto">Selecionar Produto</button>
                    <button type="button" class="btn btn-success" wire:click="save">Registrar Venda</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Modal para adicionar produto --}}
    <div class="modal fade" id="adicionarProduto" wire:ignore>
        <div class="modal-dialog modal-lg modal-dialog-scrollabe">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Adicionar Produto</h4>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <livewire:produtos.form-adicionar-produto />
                </div>
            </div>
        </div>
    </div>
</div>
