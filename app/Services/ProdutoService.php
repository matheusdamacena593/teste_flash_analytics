<?php

namespace App\Services;

use App\Exceptions\Api\MensagensDeErro;
use App\Http\Resources\ProdutoResource;
use App\Models\Produto;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProdutoService
{
    public function cadastrarProduto(array $dados)
    {
        try {
            $produto = Produto::create($dados);
            return response()->json([
                'mensagem' => 'Produto Cadastrado',
                'dados' => new ProdutoResource($produto),
                'status' => 201
            ], 201);
        } catch (\Exception $e) {
            return response()->json(MensagensDeErro::ERRO_CADASTRAR_OU_ALTERAR['ERRO_CADASTRAR_PRODUTO'], 500);
        }
    }

    public function alterarProduto(array $dados, string $id)
    {
        try {
            $produto = Produto::findOrFail($id);
            $produto->update($dados);
            return response()->json([
                'mensagem' => 'Produto Alterado',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json(MensagensDeErro::ERRO_CADASTRAR_OU_ALTERAR['ERRO_ALTERAR_PRODUTO'], 500);
        }
    }

    public function deletarProduto(string $id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            throw new HttpResponseException(response()->json(MensagensDeErro::RECURSO_NAO_ENCONTRADO['PRODUTO_NAO_ENCONTRADO'], 404));
        }
        try {
            $produto->delete();

            return response()->json([
                'mensagem' => 'Produto Deletado',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json(MensagensDeErro::ERRO_CADASTRAR_OU_ALTERAR['ERRO_ALTERAR_PRODUTO'], 500);
        }
    }
}
