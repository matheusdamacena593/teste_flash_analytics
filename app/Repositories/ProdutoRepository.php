<?php

namespace App\Repositories;

use App\Models\Produto;

class ProdutoRepository
{

    public function getById(string $id)
    {
        return Produto::find($id);
    }

    public function alterarEstoque(Produto $produto, int $quantidadeRetirada)
    {
        $produto->quantidade_estoque -= $quantidadeRetirada;
        $produto->save();

        return $produto;
    }
}
