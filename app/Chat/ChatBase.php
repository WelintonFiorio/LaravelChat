<?php

namespace App\Chat;

use App\Models\User;
use App\Repositories\MessageRepository;
use App\Message\Message;

/**
 * Classe abstrata base para chats, fornecendo funcionalidades comuns para diferentes tipos de chat.
 */
abstract class ChatBase
{
    /**
     * ID do chat.
     *
     * @var int
     */
    protected $id;

    /**
     * Nome do chat.
     *
     * @var string
     */
    protected $name;

    /**
     * Lista de usuários no chat.
     *
     * @var User[]
     */
    protected $users = [];

    /**
     * Repositório para gerenciar mensagens.
     *
     * @var MessageRepository
     */
    protected $messageRepository;

    /**
     * Construtor da classe.
     *
     * @param MessageRepository $messageRepository
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * Adiciona um usuário ao chat.
     *
     * @param User $user
     * @return void
     */
    public function addUser(User $user): void
    {
        if (!in_array($user, $this->users, true)) {
            $this->users[] = $user;
        }
    }

    /**
     * Remove um usuário do chat.
     *
     * @param User $user
     * @return void
     */
    public function removeUser(User $user): void
    {
        $this->users = array_filter($this->users, function ($u) use ($user) {
            return $u->id !== $user->id;
        });
    }

    /**
     * Envia uma mensagem no chat.
     *
     * @param string $content
     * @param User $sender
     * @return void
     */
    public function sendMessage(string $content, User $sender): void
    {
        $message = new Message([
            'content' => $content,
            'sender_id' => $sender->id,
            'chat_id' => $this->id,
        ]);

        $this->messageRepository->save($message);
    }

    /**
     * Obtém as mensagens do chat.
     *
     * @return Message[]
     */
    public function getMessages(): array
    {
        return $this->messageRepository->findByChatId($this->id);
    }

    /**
     * Obtém a lista de usuários no chat.
     *
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }
}
