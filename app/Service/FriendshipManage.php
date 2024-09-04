<?php

namespace App\Service;

use App\Contract\FriendshipManagerInterface;
use App\Models\Friendship;
use App\Contract\FriendshipRepositoryInterface;
use App\Models\User;

/**
 * Class FriendshipManage
 *
 * Implementa as operações definidas em `FriendshipManagerInterface`, gerenciando
 * as interações de amizade entre os usuários.
 */
class FriendshipManage implements FriendshipManagerInterface
{
    /**
     * O repositório de amizades utilizado para manipular dados de amizade.
     *
     * @var FriendshipRepositoryInterface
     */
    protected $friendshipRepository;

    /**
     * Construtor da classe.
     *
     * @param FriendshipRepositoryInterface $friendshipRepository O repositório de amizades a ser utilizado.
     */
    public function __construct(FriendshipRepositoryInterface $friendshipRepository)
    {
        $this->friendshipRepository = $friendshipRepository;
    }

    /**
     * Envia uma solicitação de amizade do usuário remetente para o usuário destinatário.
     *
     * @param User $sender O usuário que está enviando a solicitação de amizade.
     * @param User $friend O usuário que está recebendo a solicitação de amizade.
     * @return void
     */
    public function sendFriendRequest(User $sender, User $friend): void
    {
        $friendship = new Friendship([
            'user_id' => $sender->id,
            'friend_id' => $friend->id,
            'status' => 'pending',
        ]);

        $this->friendshipRepository->save($friendship);
    }

    /**
     * Aceita uma solicitação de amizade do usuário remetente para o usuário destinatário.
     *
     * @param User $sender O usuário que está aceitando a solicitação de amizade.
     * @param User $friend O usuário que enviou a solicitação de amizade.
     * @return void
     */
    public function acceptFriendRequest(User $sender, User $friend): void
    {
        $this->updateFriendshipStatus($sender->id, $friend->id, 'accepted');
    }

    /**
     * Rejeita uma solicitação de amizade do usuário remetente para o usuário destinatário.
     *
     * @param User $sender O usuário que está rejeitando a solicitação de amizade.
     * @param User $friend O usuário que enviou a solicitação de amizade.
     * @return bool
     */
    public function rejectFriendRequest(User $sender, User $friend): bool
    {
        $friendship = $this->findFriendship($sender->id, $friend->id);

        if ($friendship) {
            $this->friendshipRepository->delete($friendship);
            return true;
        }

        return false;
    }

    /**
     * Remove um amigo da lista de amigos do usuário remetente.
     *
     * @param User $sender O usuário que está removendo o amigo.
     * @param User $friend O usuário que está sendo removido da lista de amigos.
     * @return void
     */
    public function removeFriend(User $sender, User $friend): void
    {
        $friendship = $this->findFriendship($sender->id, $friend->id);
        if ($friendship) {
            $this->friendshipRepository->delete($friendship);
        }
    }

    /**
     * Lista todos os IDs de amigos do usuário remetente.
     *
     * @param User $sender O usuário para o qual a lista de amigos será obtida.
     * @return array Lista de IDs de amigos do usuário remetente.
     */
    public function listFriends(User $sender): array
    {
        $friendships = $this->friendshipRepository->findByUserId($sender->id);
        $friendIds = [];

        foreach ($friendships as $friendship) {
            $friendIds[] = $friendship->friend_id === $sender->id
                ? $friendship->user_id
                : $friendship->friend_id;
        }

        return $friendIds;
    }

    /**
     * Obtém o status de amizade entre o usuário remetente e o usuário destinatário.
     *
     * @param User $sender O usuário que está verificando o status de amizade.
     * @param User $friend O usuário com o qual o status de amizade será verificado.
     * @return string O status da amizade.
     */
    public function getFriendshipStatus(User $sender, User $friend): string
    {
        $friendship = $this->findFriendship($sender->id, $friend->id);
        return $friendship ? $friendship->status : 'none';
    }

    /**
     * Atualiza o status da amizade entre o usuário remetente e o usuário destinatário.
     *
     * @param int $senderId O ID do usuário remetente.
     * @param int $friendId O ID do usuário destinatário.
     * @param string $status O novo status da amizade.
     * @return void
     */
    private function updateFriendshipStatus(int $senderId, int $friendId, string $status): void
    {
        $friendship = $this->findFriendship($senderId, $friendId);

        if ($friendship) {
            $friendship->status = $status;
            $this->friendshipRepository->save($friendship);
        }
    }

    /**
     * Encontra uma instância de amizade entre o usuário remetente e o usuário destinatário.
     *
     * @param int $senderId O ID do usuário remetente.
     * @param int $friendId O ID do usuário destinatário.
     * @return Friendship|null Instância da amizade encontrada ou null se não encontrada.
     */
    private function findFriendship(int $senderId, int $friendId): ?Friendship
    {
        $friendships = $this->friendshipRepository->findByUserId($senderId);

        foreach ($friendships as $friendship) {
            if ($friendship->friend_id === $friendId || $friendship->user_id === $friendId) {
                return $friendship;
            }
        }

        return null;
    }
}
