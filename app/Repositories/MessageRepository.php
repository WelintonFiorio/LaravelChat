<?php

namespace App\Repositories;

use App\Message\Message;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MessageRepository
{
    /**
     * Salva uma mensagem no banco de dados.
     *
     * @param Message $message
     * @return Message
     */
    public function save(Message $message): Message
    {
        $message->save();
        return $message;
    }

    /**
     * Encontra uma mensagem pelo ID.
     *
     * @param int $id
     * @return Message|null
     */
    public function find(int $id): ?Message
    {
        return Message::find($id);
    }

    /**
     * Exclui uma mensagem pelo ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $message = $this->find($id);

        if ($message) {
            return $message->delete(); // Deleta a mensagem e retorna true
        }

        return false; // Retorna false se a mensagem não for encontrada
    }
    public function findByChatId(int $chatId)
    {
        return Message::where('chat_id', $chatId)->get();
    }


}
