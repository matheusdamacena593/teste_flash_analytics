<?php

namespace App\Services;

use App\Exceptions\Api\MensagensDeErro;
use App\Http\Resources\ProdutoResource;
use App\Models\Produto;
use App\Repositories\ProdutoRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class ProdutoService
{
    public function __construct(
        protected ProdutoRepository $produtoRepository,
    ) {}
    public function cadastrarProduto(array $dados)
    {
        DB::beginTransaction();
        try {
            $produto = Produto::create($dados);

            DB::commit();
            return response()->json([
                'mensagem' => 'Produto Cadastrado com sucesso',
                'dados' => new ProdutoResource($produto),
                'status' => 201
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(MensagensDeErro::ERRO_CADASTRAR_OU_ALTERAR['ERRO_CADASTRAR_PRODUTO'], 500);
        }
    }

    public function obterProduto(string $id)
    {
        $produto = $this->produtoRepository->getById($id);

        if (!$produto) {
            throw new HttpResponseException(response()->json(MensagensDeErro::RECURSO_NAO_ENCONTRADO['PRODUTO_NAO_ENCONTRADO'], 404));
        }

        return response()->json(new ProdutoResource($produto));
    }

    public function alterarProduto(array $dados, string $id)
    {
        DB::beginTransaction();
        try {
            $produto =  $this->produtoRepository->getById($id);
            $produto->update($dados);

            DB::commit();
            return response()->json([
                'mensagem' => 'Produto Alterado com sucesso',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(MensagensDeErro::ERRO_CADASTRAR_OU_ALTERAR['ERRO_ALTERAR_PRODUTO'], 500);
        }
    }

    public function deletarProduto(string $id)
    {
        DB::beginTransaction();
        $produto = $this->produtoRepository->getById($id);

        if (!$produto) {
            throw new HttpResponseException(response()->json(MensagensDeErro::RECURSO_NAO_ENCONTRADO['PRODUTO_NAO_ENCONTRADO'], 404));
        }
        try {
            $produto->delete();

            DB::commit();
            return response()->json([
                'mensagem' => 'Produto Deletado com sucesso',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(MensagensDeErro::ERRO_CADASTRAR_OU_ALTERAR['ERRO_DELETAR_PRODUTO'], 500);
        }
    }
}
