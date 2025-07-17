<?php

use App\Http\Controllers\Api\V1\PedidoController;
use App\Http\Controllers\Api\V1\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::resource('produtos', ProdutoController::class);

Route::resource('pedidos', PedidoController::class);
