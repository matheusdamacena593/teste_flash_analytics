<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    /** @use HasFactory<\Database\Factories\ProdutoFactory> */
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'quantidade_estoque',
    ];

    protected $casts = [
        'preco' => 'decimal:2',
    ];

    // Relacionamento: um produto pode estar em vários itens de pedidos
    public function itensPedidos()
    {
        return $this->hasMany(ItemPedido::class);
    }
}
