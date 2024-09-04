<?php

namespace App\Repositories;

use App\Contract\UserRepositoryInterface;
use App\Models\User;

class EloquentUserRepository implements UserRepositoryInterface
{
    /**
     * Salva um usuário no banco de dados.
     *
     * @param User $user
     * @return User
     */
    public function save(User $user): User
    {
        $user->save();
        return $user;
    }

    /**
     * Encontra um usuário pelo ID.
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Encontra um usuário pelo e-mail.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();

    }

    /**
     * Exclui um usuário do banco de dados.
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
