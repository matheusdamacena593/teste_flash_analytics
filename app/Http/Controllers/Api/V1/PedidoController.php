<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PedidoRequest;
use App\Http\Resources\PedidoResource;
use App\Models\Pedido;
use App\Services\PedidoService;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function __construct(
        protected PedidoService $pedidoService
    ) {}

    public function index()
    {
        return response()->json(PedidoResource::collection(Pedido::with('itens')->get()));
    }

    public function store(PedidoRequest $request)
    {
        return $this->pedidoService->criarPedido($request->validated());
    }

    public function show(string $id)
    {
        return $this->pedidoService->obterPedido($id);
    }

    public function update(PedidoRequest $request, string $id)
    {
        return $this->pedidoService->atualizarPedido($id, $request->validated());
    }

    public function destroy(string $id)
    {
        return $this->pedidoService->excluirPedido($id);
    }
}