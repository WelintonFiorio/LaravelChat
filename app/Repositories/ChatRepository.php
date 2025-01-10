<?php

namespace App\Repositories;

use App\Contract\ChatRepositoryInterface;
use App\Models\ChatRoom;

class ChatRepository implements ChatRepositoryInterface
{
    /**
     * Cria uma nova sala de chat com os dados fornecidos.
     *
     * Este método cria uma nova instância de ChatRoom com os dados passados
     * e salva no banco de dados. Retorna o objeto da sala de chat criada.
     *
     * @param array $data Dados necessários para criar uma sala de chat
     * @return ChatRoom A instância da sala de chat criada
     */
    public function create(array $data): ChatRoom
    {
        // Aqui você pode realizar validações adicionais se necessário
        $chatRoom = new ChatRoom($data); // Preencher os dados
        $chatRoom->save(); // Salvar no banco
        return $chatRoom; // Retornar a sala criada
    }

    /**
     * Salva ou atualiza a sala de chat no banco de dados.
     *
     * Este método salva o objeto ChatRoom fornecido no banco de dados.
     * Se a sala já existir, ela será atualizada. Caso contrário, será criada.
     *
     * @param ChatRoom $chatRoom A sala de chat a ser salva ou atualizada
     * @return ChatRoom A instância da sala de chat salva ou atualizada
     */
    public function save(ChatRoom $chatRoom): ChatRoom
    {
        $chatRoom->save();
        return $chatRoom;
    }

    /**
     * Encontra uma sala de chat pelo seu ID.
     *
     * Este método retorna uma sala de chat com o ID especificado.
     * Se a sala não for encontrada, retorna null.
     *
     * @param int $id O ID da sala de chat a ser encontrada
     * @return ChatRoom|null A sala de chat correspondente ao ID ou null se não encontrada
     */
    public function findById(int $id): ?ChatRoom
    {
        return ChatRoom::find($id);
    }

    /**
     * Deleta a sala de chat fornecida.
     *
     * Este método deleta a sala de chat fornecida do banco de dados.
     * Retorna um valor booleano indicando se a operação foi bem-sucedida.
     *
     * @param ChatRoom $chatRoom A sala de chat a ser deletada
     * @return bool Retorna true se a sala foi deletada com sucesso, false caso contrário
     */
    public function delete(ChatRoom $chatRoom): bool
    {
        return $chatRoom->delete();
    }

    /**
     * Recupera todas as salas de chat.
     *
     * Este método retorna todas as salas de chat armazenadas no banco de dados.
     *
     * @return array Um array contendo todas as salas de chat
     */
    public function findAll(): array
    {
        return ChatRoom::all()->toArray();
    }
}
