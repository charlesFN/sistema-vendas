<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;

class CategoriasController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('codigo_categoria', 'ASC')->paginate(10);

        return view('categoria.index', ['categorias' => $categorias]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo_categoria' => 'required|unique:categorias,codigo_categoria',
            'nome_categoria' => 'required',
            'descricao_categoria' => 'required',
            'icone_categoria' => ['required', File::types(['svg', 'png', 'jpg', 'jpeg', 'jpe', 'webp']),]
        ]);

        $icon = $request->icone_categoria->getClientOriginalName();

        $request->file('icone_categoria')->storeAs('public/icones_categoria', $icon);

        data_set($data, 'icone_categoria', 'storage/icones_categoria/'.$icon);

        Categoria::create($data);

        return redirect()->route('categoria.index');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'codigo_categoria' => ['required', Rule::unique('categorias')->ignore($request->id_categoria)],
            'nome_categoria' => 'required',
            'descricao_categoria' => 'required',
            'icone_categoria' => ['nullable', File::types(['svg', 'png', 'jpg', 'jpeg', 'jpe', 'webp']),]
        ]);

        $categoria = Categoria::findOrFail($request->id_categoria);

        if (isset($request->icone_categoria) == true) {
            $icon = $request->icone_categoria->getClientOriginalName();

            $request->file('icone_categoria')->storeAs('public/icones_categoria', $icon);

            data_set($data, 'icone_categoria', 'storage/icones_categoria/'.$icon);

            $categoria->update($data);
        } else {
            $categoria->update($data);
        }

        return redirect()->route('categoria.index');
    }

    public function delete(Request $request)
    {
        $categoria = Categoria::findOrFail($request->id_categoria);

        if (count($categoria->produtos) == 0) {
            $path = str_replace('storage', 'public', $categoria->icone_categoria);

            Storage::delete($path);

            $categoria->delete();
        } else {
            return redirect()->back()->with('error', 'Ainda há produtos vinculados à essa categoria!');
        }

        return redirect()->back()->with('success', 'Categoria excluída com sucesso!');
    }
}
