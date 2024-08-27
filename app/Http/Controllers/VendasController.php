<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;

class VendasController extends Controller
{
    public function index()
    {
        $vendas = Venda::orderBy('id', 'ASC')->paginate(10);

        return view('venda.index', ['vendas' => $vendas]);
    }

    public function create()
    {
        return view('venda.create');
    }

    public function show($id_venda)
    {
        $venda = Venda::findOrFail($id_venda);

        return view('venda.show', ['venda' => $venda]);
    }

    public function delete(Request $request)
    {
        $venda = Venda::findOrFail($request->id_venda);

        $venda->delete();

        return redirect()->route('venda.index')->with('success', 'Registro de venda excluído com sucesso!');
    }
}
