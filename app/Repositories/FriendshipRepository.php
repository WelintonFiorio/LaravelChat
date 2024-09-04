<?php
namespace App\Repositories;

use App\Contract\FriendshipRepositoryInterface;
use App\Models\Friendship;

/**
 * Class FriendshipRepository
 *
 * Implementa a interface `FriendshipRepositoryInterface`, manipulando instâncias
 * de `Friendship` usando o Eloquent ORM do Laravel.
 */
class FriendshipRepository implements FriendshipRepositoryInterface
{
    /**
     * Salva uma instância de Friendship no banco de dados.
     *
     * @param Friendship $friendship Instância de amizade a ser salva.
     * @return Friendship A instância de amizade salva.
     */
    public function save(Friendship $friendship): Friendship
    {
        $friendship->save();
        return $friendship;
    }

    /**
     * Busca uma amizade específica entre dois usuários.
     *
     * @param int $senderId ID do usuário que envia a solicitação de amizade.
     * @param int $friendId ID do usuário que recebe a solicitação de amizade.
     * @return Friendship|null A instância de amizade encontrada ou null se não encontrada.
     */
    public function findFriendship(int $senderId, int $friendId): ?Friendship
    {
        return Friendship::where(function($query) use ($senderId, $friendId) {
            $query->where('user_id', $senderId)->where('friend_id', $friendId);
        })->orWhere(function($query) use ($senderId, $friendId) {
            $query->where('user_id', $friendId)->where('friend_id', $senderId);
        })->first();
    }

    /**
     * Deleta uma instância de Friendship do banco de dados.
     *
     * @param Friendship $friendship Instância de amizade a ser deletada.
     * @return bool Retorna verdadeiro se a operação foi bem-sucedida.
     */
    public function delete(Friendship $friendship): bool
    {
        return $friendship->delete();
    }

    /**
     * Busca amizades pelo ID do usuário.
     *
     * @param int $userId ID do usuário para buscar amizades.
     * @return array Lista de amizades associadas ao usuário.
     */
    public function findByUserId(int $userId): array
    {
        return Friendship::where('user_id', $userId)
            ->orWhere('friend_id', $userId)
            ->get()
            ->all();

    }
}

