<?php

namespace App\Factories;

use App\Message\TextMessage;
use App\Models\User;
use DateTime;

/**
 * Classe TextMessageFactory cria instâncias de TextMessage.
 */
class TextMessageFactory implements MessageFactoryInterface
{
    /**
     * Cria uma nova instância de TextMessage.
     *
     * @param int $id
     * @param string $content
     * @param User $sender
     * @param DateTime $timestamp
     * @return TextMessage
     */
    public function create(int $id, string $content, User $sender, DateTime $timestamp): TextMessage
    {
        return new TextMessage($id, $content, $sender, $timestamp);
    }
}
