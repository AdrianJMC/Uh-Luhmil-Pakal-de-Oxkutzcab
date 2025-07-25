<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CatalogoController;

Route::get('/test', function() {
    return response()->json(['message' => 'API route works']);
});

Route::get('/catalogos/{catalogo}/agrupaciones', [CatalogoController::class, 'agrupacionesPorCatalogo']);


