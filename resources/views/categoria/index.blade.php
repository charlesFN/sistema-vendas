@extends('adminlte::page')

@section('title', 'Todas as Categorias')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h3>Categorias</h3>
        <button class="btn btn-primary" data-toggle="modal" data-target="#criarCategoria">Nova Categoria</button>
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
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Quantidade de Produtos</th>
                    <th>Opções</th>
                </thead>
                <tbody>
                    @forelse ($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->codigo_categoria }}</td>
                            <td>{{ $categoria->nome_categoria }}</td>
                            <td>{{ count($categoria->produtos) }}</td>
                            <td class="row">
                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#visualizarCategoria-{{ $categoria->id }}" aria-label="Visualizar"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning ml-2 mr-2" data-toggle="modal" data-target="#editarCategoria-{{ $categoria->id }}" aria-label="Editar"><i class="fas fa-edit"></i></button>
                                <button @if (count($categoria->produtos) > 0) disabled @endif onclick="deleteCategoria(`{{ $categoria->nome_categoria }}`, `{{ $categoria->id }}`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>

                        {{-- Modal Para Visualizar Categoria --}}
                        <div class="modal fade" id="visualizarCategoria-{{ $categoria->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ $categoria->nome_categoria }}</h4>
                                        <button class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="codigoCategoria">Código:</label>
                                            <input disabled type="text" id="codigoCategoria" class="form-control" value="{{ $categoria->codigo_categoria }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="descricaoCategoria">Descrição:</label>
                                            <textarea disabled id="descricaoCategoria" class="form-control" cols="30" rows="10">{{ $categoria->descricao_categoria }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="iconeCategoria">Ícone:</label>
                                            <div class="d-flex justify-content-center">
                                                <img src="{{ url($categoria->icone_categoria) }}" style="width:100px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Para Editar Categoria --}}
                        <div class="modal fade" id="editarCategoria-{{ $categoria->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Editar Categoria - {{ $categoria->nome_categoria }}</h4>
                                        <button class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('categoria.update') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="id_categoria" value="{{ $categoria->id }}">
                                            <div class="form-group">
                                                <label for="nomeCategoria">Nome <span class="text-danger">*</span></label>
                                                <input required type="text" name="nome_categoria" id="nomeCategoria" class="form-control" value="{{ $categoria->nome_categoria }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="codigoCategoria">Código <span class="text-danger">*</span></label>
                                                <input required type="text" name="codigo_categoria" id="codigoCategoria" class="form-control" value="{{ $categoria->codigo_categoria }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="descricaoCategoria">Descrição <span class="text-danger">*</span></label>
                                                <textarea required name="descricao_categoria" id="descricaoCategoria" class="form-control" cols="30" rows="10">{{ $categoria->descricao_categoria }}</textarea>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="iconeCategoria">Ícone Atual:</label>
                                                    <div class="d-flex justify-content-center">
                                                        <img src="{{ url($categoria->icone_categoria) }}" style="width:100px;">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="iconeCategoria">Novo Ícone <span class="text-danger">*</span></label>
                                                    <div class="d-flex justify-content-center">
                                                        <input type="file" name="icone_categoria" id="iconeCategoria" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" value="Atualizar Categoria" class="btn btn-success w-100">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- <tr colspan="3">Nenhum registro encontrado.</tr> --}}
                        <tr>
                            <td colspan="3">Nenhum registro encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $categorias->links() }}
        </div>
    </div>

    {{-- Modal Para Criar Categoria --}}
    <div class="modal fade" id="criarCategoria">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nova Categoria</h4>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('categoria.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="nomeCategoria">Nome <span class="text-danger">*</span></label>
                            <input required type="text" name="nome_categoria" id="nomeCategoria" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="codigoCategoria">Código <span class="text-danger">*</span></label>
                            <input required type="text" name="codigo_categoria" id="codigoCategoria" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="descricaoCategoria">Descrição <span class="text-danger">*</span></label>
                            <textarea required name="descricao_categoria" id="descricaoCategoria" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="iconeCategoria">Ícone <span class="text-danger">*</span></label>
                            <input required type="file" name="icone_categoria" id="iconeCategoria" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Criar Categoria" class="btn btn-success w-100">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Formulário para excluir categoria --}}
    <form action="{{ route('categoria.delete') }}" method="post" id="excluir_categoria">
        @csrf
        @method('DELETE')

        <input type="hidden" name="id_categoria" id="idCategoria">
    </form>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function deleteCategoria(categoria_nome, categoria_id) {
            Swal.fire({
                title: `Tem certeza que deseja excluir a categoria de ${categoria_nome}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, continuar',
                cancelButtonText: 'Não, cancelar'
            }).then((result) => {
                if(result.isConfirmed) {
                    document.getElementById('idCategoria').value = categoria_id;
                    $("#excluir_categoria").submit();
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
    @elseif (session()->has('error'))
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
                icon: 'error',
                title: "{{session('error')}}"
            });
        </script>
    @endif
@endsection
