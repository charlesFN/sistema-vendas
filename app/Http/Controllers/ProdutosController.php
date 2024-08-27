<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;

class ProdutosController extends Controller
{
    public function index()
    {
        $produtos = Produto::orderBy('nome_produto', 'ASC')->paginate(10);
        $categorias = Categoria::get(['id', 'nome_categoria']);

        return view('produto.index', ['produtos' => $produtos, 'categorias' => $categorias]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'categoria_produto' => 'required',
            'nome_produto' => 'required',
            'quantidade_produto' => 'required|numeric',
            'valor_produto' => 'required|numeric',
            'foto_produto' => ['required', File::types(['png', 'jpg', 'jpeg', 'jpe', 'webp']),]
        ]);

        $foto = $request->foto_produto->getClientOriginalName();

        $request->file('foto_produto')->storeAs('public/fotos_produtos', $foto);

        data_set($data, 'foto_produto', 'storage/fotos_produtos/'.$foto);

        Produto::create($data);

        return redirect()->route('produto.index');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'categoria_produto' => 'required',
            'nome_produto' => 'required',
            'quantidade_produto' => 'required|numeric',
            'valor_produto' => 'required|numeric',
            'foto_produto' => ['nullable', File::types(['png', 'jpg', 'jpeg', 'jpe', 'webp']),]
        ]);

        $produto = Produto::findOrFail($request->id_produto);

        if (isset($request->foto_produto) == true) {
            $foto = $request->foto_produto->getClientOriginalName();

            $request->file('foto_produto')->storeAs('public/fotos_produtos', $foto);

            data_set($data, 'foto_produto', 'storage/fotos_produtos/'.$foto);

            $produto->update($data);
        } else {
            $produto->update($data);
        }

        return redirect()->route('produto.index');
    }

    public function delete(Request $request)
    {
        $produto = Produto::findOrFail($request->id_produto);

        $path = str_replace('storage', 'public', $produto->foto_produto);

        Storage::delete($path);

        $produto->delete();

        return redirect()->back()->with('success', 'Produto excluído com sucesso!');
    }
}
