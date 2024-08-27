<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_produto',
        'foto_produto',
        'valor_produto',
        'categoria_produto',
        'quantidade_produto'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_produto', 'id');
    }
}
