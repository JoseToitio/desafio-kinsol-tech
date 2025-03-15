<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

// Rotas de autenticação de usuario
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});

// Rotas de att do usuario
Route::group(['middleware' => 'auth:api'], function () {
    Route::put('/user', [UserController::class, 'update'])->name('user.update'); // Atualizar usuário
    Route::delete('/user', [UserController::class, 'destroy'])->name('user.destroy');// Excluir usuário
});

// Rotas públicas de produtos (qualquer um pode acessar)
Route::get('/products', [ProductController::class, 'indexPublic']); // Lista de produtos para visitantes
Route::get('/products/{id}', [ProductController::class, 'show']); // Exibir um produto específico

// Rotas protegidas de produtos (somente usuários autenticados)
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/products', [ProductController::class, 'store'])->name('products.store'); // Criar produto
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update'); // Atualizar produto
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy'); // Excluir produto
});
