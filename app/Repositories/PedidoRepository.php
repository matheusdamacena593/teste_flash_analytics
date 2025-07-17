<?php

namespace App\Repositories;

use App\Models\Pedido;

class PedidoRepository
{
    public function getPedidoAndItensById(string $id)
    {
        return Pedido::with('itens')->find($id);
    }

    public function getPedidoById(string $id) {
        return Pedido::find($id);
    }
}
