<?php

namespace App\Contract;

use App\Models\Friendship;

/**
 * Interface FriendshipRepositoryInterface
 *
 * Define os métodos para manipulação das instâncias de `Friendship` no repositório.
 */
interface FriendshipRepositoryInterface
{
    /**
     * Salva uma instância de Friendship no repositório.
     *
     * @param Friendship $friendship Instância de amizade a ser salva.
     * @return Friendship A instância de amizade salva.
     */
    public function save(Friendship $friendship): Friendship;

    /**
     * Busca amizades pelo ID do usuário.
     *
     * @param int $userId ID do usuário para buscar amizades.
     * @return array Lista de amizades associadas ao usuário.
     */
    public function findByUserId(int $userId): array;

    /**
     * Deleta uma instância de Friendship do repositório.
     *
     * @param Friendship $friendship Instância de amizade a ser deletada.
     * @return bool Retorna verdadeiro se a operação foi bem-sucedida.
     */
    public function delete(Friendship $friendship): bool;
}
