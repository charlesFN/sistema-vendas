<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_categoria',
        'nome_categoria',
        'descricao_categoria',
        'icone_categoria'
    ];

    public function produtos()
    {
        return $this->hasMany(Produto::class, 'categoria_produto', 'id');
    }
}
