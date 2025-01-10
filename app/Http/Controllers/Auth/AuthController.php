<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\HttpResponses;

class AuthController extends Controller
{
    use HttpResponses;

    /**
     * Registra um novo usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Criação do novo usuário
        $user = User::create([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Retorna a resposta com o usuário criado
        return $this->response('User created successfully', 201, $user);
    }

    /**
     * Realiza o login de um usuário existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validação dos dados de login
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Verifica se o usuário existe no banco de dados
        $user = User::where('email', $request->email)->first();

        // Verifica as credenciais do usuário
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error('Invalid credentials', 401);
        }

        // Criação do token de autenticação
        $token = $user->createToken('auth_token')->plainTextToken;

        // Retorna a resposta com o token e dados do usuário
        return $this->response('Login successful', 200, [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
            ],
        ]);
    }

    /**
     * Realiza o logout do usuário, removendo todos os tokens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Remove todos os tokens do usuário
        $request->user()->tokens()->delete();

        // Retorna a resposta de sucesso
        return $this->response('Logged out successfully', 200);
    }
}
