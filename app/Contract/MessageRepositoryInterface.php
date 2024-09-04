<?php

namespace App\Contract;

use App\Message\Message;

/**
 * Interface MessageRepositoryInterface define os métodos para um repositório de mensagens.
 */
interface MessageRepositoryInterface
{
    /**
     * Salva uma mensagem no repositório.
     *
     * @param Message $message A mensagem a ser salva.
     * @return Message A mensagem salva, com os dados atualizados (por exemplo, o ID).
     */
    public function save(Message $message): Message;

    /**
     * Encontra uma mensagem pelo ID.
     *
     * @param int $id O ID da mensagem a ser encontrada.
     * @return Message|null A mensagem encontrada, ou null se não for encontrada.
     */
    public function find(int $id): ?Message;

    /**
     * Remove uma mensagem pelo ID.
     *
     * @param int $id O ID da mensagem a ser removida.
     * @return bool True se a mensagem foi removida com sucesso, false caso contrário.
     */
    public function delete(int $id): bool;
}
