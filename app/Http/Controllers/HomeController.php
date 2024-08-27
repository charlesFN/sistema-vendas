<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('codigo_categoria', 'ASC')->paginate(10);

        return view('categoria.index', ['categorias' => $categorias]);
    }
}
