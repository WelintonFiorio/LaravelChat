<?php

namespace App\Factories;

use App\Message\BaseMessage;
use App\Message\Message;
use App\Models\User;
use DateTime;

/**
 * Interface MessageFactoryInterface define o contrato para fábricas de mensagens.
 */
interface MessageFactoryInterface
{
    /**
     * Cria uma nova instância de Message.
     *
     * @param int $id
     * @param string $content
     * @param User $sender
     * @param DateTime $timestamp
     * @return Message
     */
    public function create(int $id, string $content, User $sender, DateTime $timestamp): BaseMessage;
}
