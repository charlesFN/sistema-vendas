@extends('adminlte::page')

@section('title', 'Nova Venda')

@section('content_header')
    <h3>Registrar Nova Venda</h3>
@stop

@section('content')
    <div>
        <livewire:vendas.nova-venda />
    </div>
@endsection
