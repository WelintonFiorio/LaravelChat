<?php

namespace App\Chat;

use App\Message\Message;
use App\Models\User;
use App\Repositories\MessageRepository;


class ChatRoom extends ChatBase
{
    protected User $mainUser; // Usuário principal
    protected ?User $participant = null; // Participante adicional

    public function __construct(User $mainUser, MessageRepository $messageRepository)
    {
        parent::__construct($messageRepository);
        $this->mainUser = $mainUser;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function addParticipant(User $participant): void
    {
        if ($this->participant === null) {
            $this->participant = $participant;
        } else {
            throw new \Exception('Já existe um participante na sala de chat.');
        }
    }

    public function removeParticipant(): void
    {
        $this->participant = null;
    }

    public function sendMessage(string $content, User $sender): void
    {
        if ($this->id === null) {
            throw new \Exception('O ID da sala de chat não está definido.');
        }

        $message = new Message([
            'content' => $content,
            'sender_id' => $sender->id,
            'chat_id' => $this->id,
        ]);

        $this->messageRepository->save($message);
    }

    public function getMessages(): array
    {
        return $this->messageRepository->findByChatId($this->id)->toArray();
    }

    public function getMainUser(): User
    {
        return $this->mainUser;
    }

    public function getParticipant(): ?User
    {
        return $this->participant;
    }
}
