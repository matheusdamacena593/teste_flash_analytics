<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    /** @use HasFactory<\Database\Factories\PedidoFactory> */
    use HasFactory;

    protected $fillable = [
        'cliente',
        'valor_total_pedido',
        'data_pedido',
    ];

    protected $casts = [
        'data_pedido' => 'datetime',
        'valor_total_pedido' => 'decimal:2',
    ];

    // Relacionamento: um pedido tem muitos itens
    public function itens()
    {
        return $this->hasMany(ItemPedido::class);
    }
}
