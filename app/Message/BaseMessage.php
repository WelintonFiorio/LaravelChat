<?php

namespace App\Message;

use App\Models\User;
use DateTime;

/**
 * Classe abstrata BaseMessage que representa uma mensagem base no sistema de chat.
 *
 * Esta classe serve como base para diferentes tipos de mensagens e fornece métodos
 * comuns para acessar os atributos da mensagem.
 */
abstract class BaseMessage
{
    /**
     * O conteúdo da mensagem.
     *
     * @var string
     */
    public string $content;

    /**
     * O timestamp da mensagem.
     *
     * @var DateTime
     */
    public DateTime $timestamp;

    /**
     * O remetente da mensagem.
     *
     * @var User
     */
    protected User $sender;

    /**
     * O ID da mensagem.
     *
     * @var int
     */
    public int $id;

    /**
     * Construtor da classe BaseMessage.
     *
     * @param int $id O ID da mensagem.
     * @param string $content O conteúdo da mensagem.
     * @param User $sender O remetente da mensagem.
     * @param DateTime $timestamp O timestamp da mensagem.
     */
    public function __construct(int $id, string $content, User $sender, DateTime $timestamp)
    {
        $this->id = $id;
        $this->content = $content;
        $this->sender = $sender;
        $this->timestamp = $timestamp;
    }

    /**
     * Obtém o conteúdo da mensagem.
     *
     * @return string O conteúdo da mensagem.
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Obtém o timestamp da mensagem.
     *
     * @return DateTime O timestamp da mensagem.
     */
    public function getTimestamp(): DateTime
    {
        return $this->timestamp;
    }

    /**
     * Obtém o remetente da mensagem.
     *
     * @return User O remetente da mensagem.
     */
    public function getSender(): User
    {
        return $this->sender;
    }

    /**
     * Obtém o ID da mensagem.
     *
     * @return int O ID da mensagem.
     */
    public function getId(): int
    {
        return $this->id;
    }
}
