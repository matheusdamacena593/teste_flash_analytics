<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\Api\MensagensDeErro;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoRequest;
use App\Http\Resources\ProdutoResource;
use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function __construct(
        protected ProdutoService $produtoService
    ) {}

    public function index()
    {
        return response()->json(ProdutoResource::collection(Produto::all()));
    }

    public function store(ProdutoRequest $request)
    {
        return $this->produtoService->cadastrarProduto($request->validated());
    }

    public function show(Request $request)
    {
        return $this->produtoService->obterProduto($request->route('produto'));
    }

    public function update(ProdutoRequest $request)
    {
        return $this->produtoService->alterarProduto($request->validated(), $request->route('produto'));
    }

    public function destroy(Request $request)
    {
        return $this->produtoService->deletarProduto($request->route('produto'));
    }
}
