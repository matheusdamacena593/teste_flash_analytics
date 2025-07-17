<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cliente' => $this->cliente,
            'itens' => $this->itens->map(fn ($item) => [
                'produtoId' => $item->produto_id,
                'nomeProduto' => $item->nome_produto,
                'quantidade' => $item->quantidade,
                'precoUnitario' => $item->preco_unitario,
                'valorTotalItem' => $item->valor_total_item,
            ]),
            'valorTotalPedido' => $this->valor_total_pedido,
            'dataPedido' => $this->data_pedido,
        ];
    }
}
