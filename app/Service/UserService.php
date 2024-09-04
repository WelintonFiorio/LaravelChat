<?php

namespace App\Service;

use App\Contract\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Registra um novo usuário.
     *
     * @param  array  $data
     * @return User
     */
    public function register(array $data): User
    {
        $user = new User();
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = $this->setPasswordAttribute($data['password']);

        $this->userRepository->save($user);
        return $user;
    }

    /**
     * Realiza o login de um usuário.
     *
     * @param  string  $email
     * @param  string  $password
     * @return User|null
     */
    public function login(string $email, string $password): ?User
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user && $this->verifyPassword($password, $user->password)) {
            Auth::login($user);
            return $user;
        }

        return null;
    }

    /**
     * Define o atributo password como hash antes de salvar.
     *
     * @param  string  $password
     * @return string
     */
    public function setPasswordAttribute(string $password): string
    {
        return Hash::make($password);
    }

    /**
     * Verifica se a senha fornecida corresponde ao hash da senha do usuário.
     *
     * @param  string  $password
     * @param  string  $hashedPassword
     * @return bool
     */
    public function verifyPassword(string $password, string $hashedPassword): bool
    {
        return Hash::check($password, $hashedPassword);
    }
}
