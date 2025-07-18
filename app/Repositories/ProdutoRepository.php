<?php

namespace App\Repositories;

use App\Models\Produto;

class ProdutoRepository
{

    public function getById(string $id)
    {
        return Produto::find($id);
    }

    public function alterarEstoque(Produto $produto, int $novaQuantidade)
    {
        $produto->quantidade_estoque = $novaQuantidade;
        $produto->save();

        return $produto;
    }
}
