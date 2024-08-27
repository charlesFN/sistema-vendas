@extends('adminlte::page')

@section('title', 'Todos os Produtos')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h3>Produtos</h3>
        <button class="btn btn-primary" data-toggle="modal" data-target="#criarProduto">Novo Produto</button>
    </div>
@stop

@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p class="text-danger">{{ $error }}</p>
        @endforeach
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-stripped table-hover">
                <thead>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Quantidade Estoque</th>
                    <th>Valor (R$)</th>
                    <th>Opções</th>
                </thead>
                <tbody>
                    @forelse ($produtos as $produto)
                        <tr>
                            <td>{{ $produto->nome_produto }}</td>
                            <td>{{ $produto->categoria->nome_categoria }}</td>
                            <td>{{ $produto->quantidade_produto }}</td>
                            <td>R$ {{ number_format($produto->valor_produto, 2, ',', '.') }}</td>
                            <td class="row">
                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#visualizarProduto-{{ $produto->id }}" aria-label="Visualizar"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning ml-2 mr-2" data-toggle="modal" data-target="#editarProduto-{{ $produto->id }}" aria-label="Editar"><i class="fas fa-edit"></i></button>
                                <button onclick="deleteProduto(`{{ $produto->nome_produto }}`, `{{ $produto->id }}`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>

                        {{-- Modal Para Visualizar Produto --}}
                        <div class="modal fade" id="visualizarProduto-{{ $produto->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ $produto->nome_produto }}</h4>
                                        <button class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="d-flex justify-content-center">
                                                <img src="{{ url($produto->foto_produto) }}" style="width:200px;">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="categoriaProduto">Categoria:</label>
                                            <input disabled type="text" id="categoriaProduto" class="form-control" value="{{ $produto->categoria->nome_categoria }}">
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="quantidadeEstoqueProduto">Quantidade Estoque:</label>
                                                <input disabled type="text" id="quantidadeEstoqueProduto" class="form-control" value="{{ $produto->quantidade_produto }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="valorProduto">Valor (R$):</label>
                                                <input disabled type="text" id="valorProduto" class="form-control" value="R$ {{ number_format($produto->valor_produto, 2, ',', '.') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Para Editar Produto --}}
                        <div class="modal fade" id="editarProduto-{{ $produto->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Editar Produto</h4>
                                        <button class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('produto.update') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="id_produto" value="{{ $produto->id }}">
                                            <div class="form-group">
                                                <label for="nomeCategoriaProduto">Categoria <span class="text-danger">*</span></label>
                                                <select name="categoria_produto" id="nomeCategoriaProduto" class="form-control">
                                                    <option value="{{ $produto->categoria_produto }}" selected>{{ $produto->categoria->nome_categoria }}</option>
                                                    @foreach ($categorias as $categoria)
                                                        <option value="{{ $categoria->id }}">{{ $categoria->nome_categoria }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="nomeProduto">Nome <span class="text-danger">*</span></label>
                                                <input required type="text" name="nome_produto" id="nomeProduto" class="form-control" value="{{ $produto->nome_produto }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="quantidadeProduto">Quantidade <span class="text-danger">*</span></label>
                                                <input required type="number" step="1" name="quantidade_produto" id="quantidadeProduto" class="form-control" value="{{ $produto->quantidade_produto }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="valorProduto">Valor (R$) <span class="text-danger">*</span></label>
                                                <input required type="number" step="0.01" name="valor_produto" id="valorProduto" class="form-control" value="{{ $produto->valor_produto }}">
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="fotoProduto">Foto Atual:</label>
                                                    <div class="d-flex justify-content-center">
                                                        <img src="{{ url($produto->foto_produto) }}" style="width:200px;">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="fotoProduto">Nova Foto <span class="text-danger">*</span></label>
                                                    <div class="d-flex justify-content-center">
                                                        <input type="file" name="foto_produto" id="fotoProduto" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" value="Atualizar Produto" class="btn btn-success w-100">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="3">Nenhum registro encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $produtos->links() }}
        </div>
    </div>

    {{-- Modal Para Criar Produto --}}
    <div class="modal fade" id="criarProduto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Novo Produto</h4>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('produto.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="nomeCategoriaProduto">Categoria <span class="text-danger">*</span></label>
                            <select name="categoria_produto" id="nomeCategoriaProduto" class="form-control">
                                <option value="" selected>Selecione uma categoria</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nome_categoria }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomeProduto">Nome <span class="text-danger">*</span></label>
                            <input required type="text" name="nome_produto" id="nomeProduto" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="quantidadeProduto">Quantidade <span class="text-danger">*</span></label>
                            <input required type="number" step="1" name="quantidade_produto" id="quantidadeProduto" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="valorProduto">Valor (R$) <span class="text-danger">*</span></label>
                            <input required type="number" step="0.01" name="valor_produto" id="valorProduto" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="fotoProduto">Foto <span class="text-danger">*</span></label>
                            <input required type="file" name="foto_produto" id="fotoProduto" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Criar Produto" class="btn btn-success w-100">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Formulário para excluir produto --}}
    <form action="{{ route('produto.delete') }}" method="post" id="excluir_produto">
        @csrf
        @method('DELETE')

        <input type="hidden" name="id_produto" id="idProduto">
    </form>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function deleteProduto(produto_nome, produto_id) {
            Swal.fire({
                title: `Tem certeza que deseja excluir o produto: ${produto_nome}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, continuar',
                cancelButtonText: 'Não, cancelar'
            }).then((result) => {
                if(result.isConfirmed) {
                    document.getElementById('idProduto').value = produto_id;
                    $("#excluir_produto").submit();
                }
            })
        }
    </script>

    @if (session()->has('success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            })
        </script>
    @endif
@endsection
