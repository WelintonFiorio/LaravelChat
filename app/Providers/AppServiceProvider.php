<?php

namespace App\Providers;

use App\Contract\FriendshipRepositoryInterface;
use App\Contract\UserRepositoryInterface;
use App\Repositories\EloquentUserRepository;
use App\Repositories\FriendshipRepository;
use Illuminate\Support\ServiceProvider;

use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrando o repositório de usuários no container de injeção de dependência
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );
        // Registro da interface FriendshipRepositoryInterface com a implementação FriendshipRepository
        $this->app->bind(
            FriendshipRepositoryInterface::class,
            FriendshipRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

    }
}
