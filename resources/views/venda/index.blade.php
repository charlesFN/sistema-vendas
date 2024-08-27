@extends('adminlte::page')

@section('title', 'Todas as Vendas')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h3>Vendas</h3>
        <a href="{{ route('venda.create') }}" class="btn btn-primary">Nova Venda</a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-hover table-stripped">
                <thead>
                    <th>#</th>
                    <th>Quantidade de Produtos</th>
                    <th>Valor Total da Venda (R$)</th>
                    <th></th>
                </thead>
                <tbody>
                    @forelse ($vendas as $venda)
                        <tr>
                            <td>{{ $venda->id }}</td>
                            <td>{{ $venda->qtd_total_produtos }}</td>
                            <td>R$ {{ number_format($venda->valor_total_venda, 2, ',', '.') }}</td>
                            <td class="row">
                                <a href="{{ route('venda.show', ['id_venda' => $venda->id]) }}" class="btn btn-sm btn-info mr-2"><i class="fas fa-eye"></i></a>
                                <button onclick="deleteVenda(`{{ $venda->id }}`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhum registro encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">

        </div>
    </div>

    {{-- Formulário para excluir venda --}}
    <form action="{{ route('venda.delete') }}" method="post" id="excluir_venda">
        @csrf
        @method('DELETE')

        <input type="hidden" name="id_venda" id="idVenda">
    </form>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function deleteVenda(venda_id) {
            Swal.fire({
                title: `Tem certeza que deseja excluir estre registro?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, continuar',
                cancelButtonText: 'Não, cancelar'
            }).then((result) => {
                if(result.isConfirmed) {
                    document.getElementById('idVenda').value = venda_id;
                    $("#excluir_venda").submit();
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

