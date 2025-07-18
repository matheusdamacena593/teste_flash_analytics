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
        return $this->pedidoService->cadastrarPedido($request->validated());
    }

    public function show(Request $request)
    {
        return $this->pedidoService->obterPedido($request->route('pedido'));
    }

    public function update(PedidoRequest $request)
    {
        return $this->pedidoService->alterarPedido($request->validated(), $request->route('pedido'));
    }

    public function destroy(Request $request)
    {
        return $this->pedidoService->deletarPedido($request->route('pedido'));
    }
}
