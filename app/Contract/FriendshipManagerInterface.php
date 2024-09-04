<?php

namespace App\Contract;

use App\Models\User;

/**
 * Interface FriendshipManagerInterface
 *
 * Define os métodos para gerenciar as operações de amizade entre usuários.
 */
interface FriendshipManagerInterface
{
    /**
     * Envia uma solicitação de amizade de um usuário (sender) para outro (friend).
     *
     * @param User $sender Usuário que envia a solicitação.
     * @param User $friend Usuário que recebe a solicitação.
     */
    public function sendFriendRequest(User $sender, User $friend): void;

    /**
     * Aceita uma solicitação de amizade entre dois usuários.
     *
     * @param User $sender Usuário que aceitou a solicitação.
     * @param User $friend Usuário que enviou a solicitação.
     */
    public function acceptFriendRequest(User $sender, User $friend): void;

    /**
     * Rejeita uma solicitação de amizade entre dois usuários.
     *
     * @param User $sender Usuário que rejeita a solicitação.
     * @param User $friend Usuário que enviou a solicitação.
     */
    public function rejectFriendRequest(User $sender, User $friend): bool;

    /**
     * Remove uma amizade entre dois usuários.
     *
     * @param User $sender Usuário que remove a amizade.
     * @param User $friend Usuário que é removido da lista de amigos.
     */
    public function removeFriend(User $sender, User $friend): void;

    /**
     * Retorna uma lista de amigos de um usuário.
     *
     * @param User $sender Usuário para o qual a lista de amigos será obtida.
     * @return array Lista de amigos do usuário.
     */
    public function listFriends(User $sender): array;

    /**
     * Retorna o status de amizade entre dois usuários.
     *
     * @param User $sender Usuário que está verificando o status de amizade.
     * @param User $friend Usuário com o qual o status de amizade será verificado.
     * @return string O status da amizade.
     */
    public function getFriendshipStatus(User $sender, User $friend): string;
}
