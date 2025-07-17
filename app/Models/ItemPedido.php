<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    /** @use HasFactory<\Database\Factories\ItemPedidoFactory> */
    use HasFactory;

    protected $table = 'itens_pedidos';

    protected $fillable = [
        'pedido_id',
        'produto_id',
        'nome_produto',
        'quantidade',
        'preco_unitario',
        'valor_total_item',
    ];

    protected $casts = [
        'preco_unitario' => 'decimal:2',
        'valor_total_item' => 'decimal:2',
    ];

    // Relacionamento: item pertence a um pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    // Relacionamento: item pertence a um produto
    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
