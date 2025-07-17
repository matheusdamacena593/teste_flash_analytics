<?php

use App\Http\Controllers\Api\V1\ProdutoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('produtos', ProdutoController::class);
