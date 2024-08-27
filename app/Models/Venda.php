<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = [
        'produtos',
        'qtd_produtos',
        'qtd_total_produtos',
        'valor_total_venda',
    ];

    protected $casts = [
        'produtos' => 'array',
        'qtd_produtos' => 'array'
    ];
}
