<?php

namespace App\Services;

use App\Exceptions\Api\MensagensDeErro;
use App\Http\Resources\PedidoResource;
use App\Models\ItemPedido;
use App\Models\Pedido;
use App\Models\Produto;
use App\Repositories\PedidoRepository;
use App\Repositories\ProdutoRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class PedidoService
{
    public function __construct(
        protected ProdutoRepository $produtoRepository,
        protected PedidoRepository $pedidoRepository,
    ) {}
    public function cadastrarPedido(array $dados)
    {
        DB::beginTransaction();

        try {
            $valorTotal = 0;
            $itensInseridos = [];

            foreach ($dados['itens'] as $item) {
                $produto = $this->produtoRepository->getById($item['produto_id']);
                $quantidade = $item['quantidade'];

                if ($quantidade > $produto['quantidade_estoque']) {
                    return response()->json(['error' => MensagensDeErro::ERRO_NO_ESTOQUE['FALTA_ESTOQUE'], 'produto' => $produto->nome], 500);
                }

                $this->produtoRepository->alterarEstoque($produto, $quantidade);

                $preco = $produto->preco;
                $totalItem = $preco * $quantidade;

                $valorTotal += $totalItem;

                $itensInseridos[] = [
                    'produto_id' => $produto->id,
                    'nome_produto' => $produto->nome,
                    'quantidade' => $quantidade,
                    'preco_unitario' => $preco,
                    'valor_total_item' => $totalItem,
                ];
            }

            $pedido = Pedido::create([
                'cliente' => $dados['cliente'],
                'data_pedido' => now(),
                'valor_total_pedido' => $valorTotal,
            ]);

            $pedido->itens()->createMany($itensInseridos);

            DB::commit();

            return response()->json([
                'mensagem' => 'Pedido cadastrado com sucesso',
                'dados' => new PedidoResource($pedido->fresh('itens')),
                'status' => 201
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new HttpResponseException(response()->json(MensagensDeErro::ERRO_CADASTRAR_OU_ALTERAR['ERRO_CADASTRAR_PEDIDO'], 500));
        }
    }

    public function obterPedido(string $id)
    {
        $pedido = $this->pedidoRepository->getPedidoAndItensById($id);

        if (!$pedido) {
            throw new HttpResponseException(response()->json(MensagensDeErro::RECURSO_NAO_ENCONTRADO['PEDIDO_NAO_ENCONTRADO'], 404));
        }

        return response()->json(new PedidoResource($pedido));
    }

    public function alterarPedido(array $dados, string $id,)
    {
        DB::beginTransaction();

        try {
            $pedido = $this->pedidoRepository->getPedidoById($id);

            foreach ($pedido->itens as $itemAntigo) {
                $produto = $this->produtoRepository->getById($itemAntigo->produto_id);
                $novaQuantidade = $produto->quantidade_estoque + $itemAntigo->quantidade;
                $this->produtoRepository->alterarEstoque($produto, $novaQuantidade);
            }

            $pedido->itens()->delete();

            $valorTotal = 0;
            $itensInseridos = [];

            foreach ($dados['itens'] as $item) {
                $produto = $this->produtoRepository->getById($item['produto_id']);
                $quantidade = $item['quantidade'];

                if ($quantidade > $produto->quantidade_estoque) {
                    return response()->json(['error' => MensagensDeErro::ERRO_NO_ESTOQUE['FALTA_ESTOQUE'], 'produto' => $produto->nome], 500);
                }

                $novaQuantidade = $produto->quantidade_estoque - $quantidade;
                $this->produtoRepository->alterarEstoque($produto, $novaQuantidade);

                $preco = $produto->preco;
                $totalItem = $preco * $quantidade;

                $valorTotal += $totalItem;

                $itensInseridos[] = [
                    'produto_id' => $produto->id,
                    'nome_produto' => $produto->nome,
                    'quantidade' => $quantidade,
                    'preco_unitario' => $preco,
                    'valor_total_item' => $totalItem,
                ];
            }

            $pedido->update([
                'cliente' => $dados['cliente'],
                'valor_total_pedido' => $valorTotal,
            ]);

            $pedido->itens()->createMany($itensInseridos);

            DB::commit();

            return response()->json([
                'mensagem' => 'Pedido alterado com sucesso',
                'dados' => new PedidoResource($pedido->fresh('itens')),
                'status' => 200
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new HttpResponseException(response()->json(MensagensDeErro::ERRO_CADASTRAR_OU_ALTERAR['ERRO_ALTERAR_PEDIDO'], 500));
        }
    }

    public function deletarPedido(string $id)
    {
        $pedido = $this->pedidoRepository->getPedidoById($id);

        if (!$pedido) {
            throw new HttpResponseException(response()->json(MensagensDeErro::RECURSO_NAO_ENCONTRADO['PEDIDO_NAO_ENCONTRADO'], 404));
        }

        try {
            $pedido->itens()->delete();
            $pedido->delete();

            return response()->json([
                'mensagem' => 'Pedido deletado com sucesso',
                'status' => 200
            ]);
        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json(MensagensDeErro::ERRO_CADASTRAR_OU_ALTERAR['ERRO_DELETAR_PEDIDO'], 500));
        }
    }
}
