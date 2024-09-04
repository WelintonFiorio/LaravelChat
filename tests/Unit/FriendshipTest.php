<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Friendship;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FriendshipTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa a criação de uma amizade.
     *
     * @return void
     */
    public function test_can_create_a_friendship()
    {
        // Criação dos usuários com username
        $user1 = User::create([
            'username' => 'userone',
            'email' => 'userone@example.com',
            'password' => bcrypt('password'),
        ]);

        $user2 = User::create([
            'username' => 'usertwo',
            'email' => 'usertwo@example.com',
            'password' => bcrypt('password'),
        ]);

        // Criação da amizade
        $friendship = Friendship::create([
            'user_id' => $user1->id,
            'friend_id' => $user2->id,
            'status' => 'pending',
        ]);

        // Verifica se a amizade foi criada corretamente
        $this->assertDatabaseHas('friendships', [
            'user_id' => $user1->id,
            'friend_id' => $user2->id,
            'status' => 'pending',
        ]);
    }

    /**
     * Testa a obtenção e definição do ID do usuário na amizade.
     *
     * @return void
     */
    public function test_can_get_and_set_user_id()
    {
        $friendship = new Friendship();

        // Define o ID do usuário
        $friendship->user_id = 1;

        // Verifica se o ID do usuário foi definido corretamente
        $this->assertEquals(1, $friendship->user_id);
    }

    /**
     * Testa a obtenção e definição do ID do amigo na amizade.
     *
     * @return void
     */
    public function test_can_get_and_set_friend_id()
    {
        $friendship = new Friendship();

        // Define o ID do amigo
        $friendship->friend_id = 2;

        // Verifica se o ID do amigo foi definido corretamente
        $this->assertEquals(2, $friendship->friend_id);
    }

    /**
     * Testa a obtenção e definição do status da amizade.
     *
     * @return void
     */
    public function test_can_get_and_set_status()
    {
        $friendship = new Friendship();

        // Define o status da amizade
        $friendship->status = 'accepted';

        // Verifica se o status foi definido corretamente
        $this->assertEquals('accepted', $friendship->status);
    }
}
