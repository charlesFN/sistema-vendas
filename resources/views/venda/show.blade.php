@extends('adminlte::page')

@section('title', 'Visualizar Venda')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h3>Visualizar Detalhes da Venda</h3>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="card col-md-6">
            <div class="card-body">
                <table class="table table-hover table-stripped">
                    <thead>
                        <th>Produtos</th>
                    </thead>
                    <tbody>
                        @foreach ($venda->produtos as $produto)
                            <tr>
                                <td>{{ $produto }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card col-md-6">
            <div class="card-body">
                <table class="table table-hover table-stripped">
                    <thead>
                        <th>Quantidade</th>
                    </thead>
                    <tbody>
                        @foreach ($venda->qtd_produtos as $qtd_produto)
                            <tr>
                                <td>{{ $qtd_produto }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card col-md-12">
            <div class="card-body">
                <table class="table table-hover table-stripped">
                    <thead>
                        <th>Valor Total (R$)</th>
                        <th>Total de Produtos Vendidos</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>R$ {{ number_format($venda->valor_total_venda, 2, ',', '.') }}</td>
                            <td>{{ $venda->qtd_total_produtos }} unidade (s) vendida (s)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
