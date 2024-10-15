<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Expor o endpoint para autenticar o usuário
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

// Definir rotas de CRUD para o controlador TaskController
// Essas rotas permitem operações de CRUD para tarefas
Route::apiResource('tasks', TaskController::class)->middleware('auth:sanctum');
