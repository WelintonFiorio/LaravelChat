<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Certifique-se de importar Str para gerar o nome aleatório
use App\Traits\HttpResponses;

class ChatController extends Controller
{
    use HttpResponses; // Importa o Trait para respostas HTTP padronizadas

    /**
     * Cria uma nova sala de chat.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @description
     * - Valida os campos 'name' (opcional) e 'is_group' (booleano opcional).
     * - Gera um nome aleatório para a sala caso o campo 'name' não seja fornecido.
     * - Define 'is_group' como false por padrão.
     * - Cria e retorna uma nova sala de chat com os dados fornecidos.
     */
    public function createChat(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'is_group' => 'nullable|boolean',
        ]);

        $name = $request->input('name', Str::random(6));
        $is_group = $request->input('is_group', false);

        $chatRoom = ChatRoom::create([
            'name' => $name,
            'is_group' => $is_group,
        ]);

        return $this->response('Chat room created successfully.', 201, $chatRoom);
    }

    /**
     * Adiciona um usuário a uma sala de chat.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @description
     * - Valida os campos 'user_id' e 'chat_room_id'.
     * - Verifica se o usuário já está na sala de chat.
     * - Adiciona o usuário à sala de chat e retorna os dados atualizados da sala.
     */
    public function addUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'chat_room_id' => 'required|exists:chat_rooms,id',
        ]);

        $chatRoom = ChatRoom::find($request->chat_room_id);
        $user = User::find($request->user_id);

        if ($chatRoom->users->contains($user->id)) {
            return $this->error('User already exists in chat room.', 400);
        }

        $this->attach($chatRoom, $user);

        return $this->response('User added successfully to chat room.', 200, $chatRoom->load('users'));
    }

    /**
     * Remove um usuário de uma sala de chat.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @description
     * - Valida os campos 'user_id' e 'chat_room_id'.
     * - Verifica se o usuário está presente na sala de chat.
     * - Remove o usuário da sala de chat e retorna os dados atualizados da sala.
     */
    public function removeUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'chat_room_id' => 'required|exists:chat_rooms,id'
        ]);

        $chatRoom = ChatRoom::find($request->chat_room_id);
        $user = User::find($request->user_id);

        if (!$chatRoom->users()->where('user_id', $user->id)->exists()) {
            return $this->error('User is not in this chat room.', 400);
        }

        $this->detach($chatRoom, $user);

        return $this->response('User removed successfully from chat room.', 200, $chatRoom->load('users'));
    }

    /**
     * Remove a relação entre uma sala de chat e um usuário.
     *
     * @param \App\Models\ChatRoom $chatRoom
     * @param \App\Models\User $user
     * @return void
     *
     * @description
     * - Remove o vínculo entre o usuário e a sala de chat usando o método `detach`.
     */
    private function detach(ChatRoom $chatRoom, User $user)
    {
        $chatRoom->users()->detach($user->id);
    }

    /**
     * Adiciona a relação entre uma sala de chat e um usuário.
     *
     * @param \App\Models\ChatRoom $chatRoom
     * @param \App\Models\User $user
     * @return void
     *
     * @description
     * - Cria o vínculo entre o usuário e a sala de chat usando o método `attach`.
     */
    private function attach(ChatRoom $chatRoom, User $user)
    {
        $chatRoom->users()->attach($user->id);
    }
}
