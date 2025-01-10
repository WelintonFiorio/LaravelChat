<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Chat\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Este arquivo contém todas as rotas da API para o projeto. As rotas de autenticação
| e outras funcionalidades de interação com o sistema são registradas aqui.
|
*/

// Rotas de autenticação

// Rota para registro de um novo usuário
// A requisição POST para '/register' invoca o método 'register' do AuthController,
// onde o usuário envia os dados necessários (como username, email, password) para se registrar no sistema.
Route::post('/register', [AuthController::class, 'register']);

// Rota para login de um usuário existente
// A requisição POST para '/login' invoca o método 'login' do AuthController,
// onde o usuário envia suas credenciais (email e password) para autenticação e recebe um token de acesso.
Route::post('/login', [AuthController::class, 'login']);



//cria uma sala de chat pelo insomina

Route::post('/create-chat', [ChatController::class, 'createChat']);
Route::post('/add-user', [ChatController::class, 'addUser']);
Route::post('/remove-user', [ChatController::class, 'removeUser']);



