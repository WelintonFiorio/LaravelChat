<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Friendship;
use App\Service\FriendshipManage;
use App\Contract\FriendshipRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class FriendshipManageFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Criação dos usuários necessários
        $this->user1 = User::factory()->create();
        $this->user2 = User::factory()->create();
        $this->user3 = User::factory()->create();

        // Criação do mock para o repositório de amizades
        $this->friendshipRepository = Mockery::mock(FriendshipRepositoryInterface::class);
        $this->friendshipManage = new FriendshipManage($this->friendshipRepository);
    }

    /** @test */
    public function user_can_send_friend_request()
    {
        $this->friendshipRepository
            ->shouldReceive('save')
            ->once()
            ->with(Mockery::on(function (Friendship $mockFriendship) {
                return $mockFriendship->user_id === $this->user1->id &&
                    $mockFriendship->friend_id === $this->user2->id &&
                    $mockFriendship->status === 'pending';
            }));

        $this->friendshipManage->sendFriendRequest($this->user1, $this->user2);
    }

    /** @test */
    public function user_can_accept_friend_request()
    {
        $friendship = new Friendship([
            'user_id' => $this->user1->id,
            'friend_id' => $this->user2->id,
            'status' => 'pending',
        ]);

        $this->friendshipRepository
            ->shouldReceive('findByUserId')
            ->once()
            ->with($this->user2->id)
            ->andReturn([$friendship]);

        $this->friendshipRepository
            ->shouldReceive('save')
            ->once()
            ->with(Mockery::on(function (Friendship $mockFriendship) use ($friendship) {
                return $mockFriendship->user_id === $friendship->user_id &&
                    $mockFriendship->friend_id === $friendship->friend_id &&
                    $mockFriendship->status === 'accepted';
            }))
            ->andReturn($friendship);

        $this->friendshipManage->acceptFriendRequest($this->user2, $this->user1);
    }



    /** @test */
    public function user_can_reject_friend_request()
    {
        $friendship = new Friendship([
            'user_id' => $this->user1->id,
            'friend_id' => $this->user2->id,
            'status' => 'pending',
        ]);

        // Espera-se que o método findByUserId retorne a amizade pendente.
        $this->friendshipRepository
            ->shouldReceive('findByUserId')
            ->once()
            ->with($this->user1->id)
            ->andReturn([$friendship]);

        // Espera-se que o método delete seja chamado para a amizade.
        $this->friendshipRepository
            ->shouldReceive('delete')
            ->once()
            ->with($friendship)
            ->andReturn(true);

        $result = $this->friendshipManage->rejectFriendRequest($this->user1, $this->user2);

        // Verifica se o método retornou true.
        $this->assertTrue($result);
    }



    /** @test */
    public function user_can_remove_friend()
    {
        $friendship = new Friendship([
            'user_id' => $this->user1->id,
            'friend_id' => $this->user2->id,
            'status' => 'accepted',
        ]);

        $this->friendshipRepository
            ->shouldReceive('findByUserId')
            ->once()
            ->with($this->user1->id)
            ->andReturn([$friendship]);

        $this->friendshipRepository
            ->shouldReceive('delete')
            ->once()
            ->with($friendship)
            ->andReturn(true);

        $this->friendshipManage->removeFriend($this->user1, $this->user2);
    }


    /** @test */
    public function user_can_list_friends()
    {
        $friendship = Friendship::create([
            'user_id' => $this->user1->id,
            'friend_id' => $this->user2->id,
            'status' => 'accepted',
        ]);

        $this->friendshipRepository
            ->shouldReceive('findByUserId')
            ->once()
            ->with($this->user1->id)
            ->andReturn([$friendship]);

        $friendIds = $this->friendshipManage->listFriends($this->user1);

        $this->assertEquals([$this->user2->id], $friendIds);
    }

    /** @test */
    public function user_can_get_friendship_status()
    {
        $friendship = Friendship::create([
            'user_id' => $this->user1->id,
            'friend_id' => $this->user2->id,
            'status' => 'accepted',
        ]);

        $this->friendshipRepository
            ->shouldReceive('findByUserId')
            ->once()
            ->with($this->user1->id)
            ->andReturn([$friendship]);

        $status = $this->friendshipManage->getFriendshipStatus($this->user1, $this->user2);

        $this->assertEquals('accepted', $status);
    }
}
