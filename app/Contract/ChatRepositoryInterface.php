<?php

namespace App\Contract;

use App\Models\ChatRoom;

/**
 * Interface ChatRoomRepositoryInterface
 *
 * Esta interface define as operações necessárias para gerenciar as salas de chat (chat rooms) no sistema.
 * Ela especifica os métodos para criar, salvar, buscar, excluir e listar salas de chat.
 *
 * @package App\Contract
 */
interface ChatRepositoryInterface
{
    /**
     * Cria ou atualiza uma sala de chat.
     *
     * @param ChatRoom $chatRoom A instância do modelo ChatRoom que será salva ou atualizada.
     *
     * @return ChatRoom Retorna a instância do ChatRoom após a criação ou atualização no banco de dados.
     */
    public function save(ChatRoom $chatRoom): ChatRoom;

    /**
     * Encontra uma sala de chat pelo ID fornecido.
     *
     * @param int $id O ID da sala de chat a ser buscada.
     *
     * @return ChatRoom|null Retorna a instância do modelo ChatRoom caso a sala seja encontrada ou null caso contrário.
     */
    public function findById(int $id): ?ChatRoom;

    /**
     * Exclui uma sala de chat do sistema.
     *
     * @param ChatRoom $chatRoom A instância do modelo ChatRoom a ser deletada.
     *
     * @return bool Retorna true se a exclusão for bem-sucedida ou false caso contrário.
     */
    public function delete(ChatRoom $chatRoom): bool;

    /**
     * Recupera todas as salas de chat existentes no sistema.
     *
     * @return array Retorna um array contendo todas as instâncias do modelo ChatRoom.
     */
    public function findAll(): array;
}
