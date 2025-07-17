<?php

namespace App\Repositories;

use App\Models\Produto;

class ProdutoRepository
{

    public function findById(string $id)
    {
        return Produto::findOrFail($id);
    }

    public function alterarEstoque(Produto $produto, int $quantidadeRetirada)
    {
        $produto->quantidade_estoque -= $quantidadeRetirada;
        $produto->save();

        return $produto;
    }
}
