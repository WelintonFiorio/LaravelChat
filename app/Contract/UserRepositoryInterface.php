<?php

namespace App\Contract;

use App\Models\User;

/**
 * Interface UserRepositoryInterface
 *
 * Define as operações básicas de um repositório de usuários.
 *
 * @package App\Repositories
 */
interface UserRepositoryInterface
{
    /**
     * Salva um usuário no repositório.
     *
     * @param User $user O usuário a ser salvo.
     *
     * @return void
     */
    public function save(User $user): User;

    /**
     * Encontra um usuário pelo seu ID.
     *
     * @param int $id O ID do usuário a ser encontrado.
     *
     * @return User|null Retorna o usuário se encontrado, ou null se não encontrado.
     */
    public function findById(int $id): ?User;

    /**
     * Encontra um usuário pelo seu e-mail.
     *
     * @param string $email O e-mail do usuário a ser encontrado.
     *
     * @return User|null Retorna o usuário se encontrado, ou null se não encontrado.
     */
    public function findByEmail(string $email): ?User;

    /**
     * Deleta um usuário do repositório.
     *
     * @param User $user O usuário a ser deletado.
     *
     * @return bool Retorna true se a operação de deleção for bem-sucedida, ou false caso contrário.
     */
    public function delete(User $user): bool;
}
