<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\VendasController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/categorias', [CategoriasController::class, 'index'])->name('categoria.index');
Route::post('/categorias/store', [CategoriasController::class, 'store'])->name('categoria.store');
Route::put('/categorias/update', [CategoriasController::class, 'update'])->name('categoria.update');
Route::delete('/categorias/delete/', [CategoriasController::class, 'delete'])->name('categoria.delete');

Route::get('/produtos', [ProdutosController::class, 'index'])->name('produto.index');
Route::post('/produtos/store', [ProdutosController::class, 'store'])->name('produto.store');
Route::put('/produtos/update', [ProdutosController::class, 'update'])->name('produto.update');
Route::delete('/produtos/delete/', [ProdutosController::class, 'delete'])->name('produto.delete');

Route::get('/vendas', [VendasController::class, 'index'])->name('venda.index');
Route::get('/vendas/create', [VendasController::class, 'create'])->name('venda.create');
Route::get('/vendas/show/{id_venda}', [VendasController::class, 'show'])->name('venda.show');
Route::delete('/vendas/delete', [VendasController::class, 'delete'])->name('venda.delete');
