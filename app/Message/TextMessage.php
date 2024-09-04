<?php

namespace App\Message;

use App\Models\User;
use DateTime;

/**
 * Classe TextMessage que representa uma mensagem de texto no sistema de chat.
 *
 * Esta classe estende a classe BaseMessage e adiciona a funcionalidade específica para
 * mensagens de texto. Atualmente, não adiciona novas propriedades ou métodos, mas serve
 * como uma especialização de BaseMessage para mensagens de texto.
 */
class TextMessage extends BaseMessage
{
    /**
     * Construtor da classe TextMessage.
     *
     * @param int $id O ID da mensagem.
     * @param string $content O conteúdo da mensagem de texto.
     * @param User $sender O remetente da mensagem.
     * @param DateTime $timestamp O timestamp da mensagem.
     */
    public function __construct(int $id, string $content, User $sender, DateTime $timestamp)
    {
        parent::__construct($id, $content, $sender, $timestamp);
    }
}
