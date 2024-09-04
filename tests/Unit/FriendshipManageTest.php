<?php

namespace Tests\Unit;

use App\Contract\FriendshipRepositoryInterface;
use App\Models\User;
use App\Models\Friendship;
use App\Service\FriendshipManage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class FriendshipManageTest extends TestCase
{
    use RefreshDatabase;

    protected $friendshipManage;
    protected $friendshipRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->friendshipRepository = Mockery::mock(FriendshipRepositoryInterface::class);
        $this->friendshipManage = new FriendshipManage($this->friendshipRepository);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testSendFriendRequest()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $friendship = new Friendship([
            'user_id' => $user1->id,
            'friend_id' => $user2->id,
            'status' => 'pending',
        ]);

        $this->friendshipRepository
            ->shouldReceive('save')
            ->once()
            ->with(Mockery::on(function ($arg) use ($friendship) {
                return $arg->user_id === $friendship->user_id &&
                    $arg->friend_id === $friendship->friend_id &&
                    $arg->status === $friendship->status;
            }));

        $this->friendshipManage->sendFriendRequest($user1, $user2);

        // Verificação do comportamento esperado
        $this->assertTrue(true); // Se necessário, ajuste isso conforme o comportamento esperado.
    }

    public function testAcceptFriendRequest()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $friendship = new Friendship([
            'user_id' => $user1->id,
            'friend_id' => $user2->id,
            'status' => 'pending',
        ]);

        $this->friendshipRepository
            ->shouldReceive('findByUserId')
            ->once()
            ->with($user1->id)
            ->andReturn([$friendship]);

        $this->friendshipRepository
            ->shouldReceive('save')
            ->once()
            ->with(Mockery::on(function ($arg) use ($friendship) {
                return $arg->user_id === $friendship->user_id &&
                    $arg->friend_id === $friendship->friend_id &&
                    $arg->status === 'accepted';
            }));

        $this->friendshipManage->acceptFriendRequest($user1, $user2);

        // Verificação do comportamento esperado
        $this->assertTrue(true); // Se necessário, ajuste isso conforme o comportamento esperado.
    }

    public function testRejectFriendRequest()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $friendship = new Friendship([
            'user_id' => $user1->id,
            'friend_id' => $user2->id,
            'status' => 'pending',
        ]);

        // Expectativa para findByUserId
        $this->friendshipRepository
            ->shouldReceive('findByUserId')
            ->once()
            ->with($user1->id)
            ->andReturn([$friendship]);

        // Expectativa para delete
        $this->friendshipRepository
            ->shouldReceive('delete')
            ->once()
            ->with($friendship)
            ->andReturn(true); // Adicionando retorno para o método delete

        $result = $this->friendshipManage->rejectFriendRequest($user1, $user2);

        // Verificando se o método retornou true
        $this->assertTrue($result);
    }


    public function testRemoveFriend()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $friendship = new Friendship([
            'user_id' => $user1->id,
            'friend_id' => $user2->id,
            'status' => 'accepted',
        ]);

        $this->friendshipRepository
            ->shouldReceive('findByUserId')
            ->once()
            ->with($user1->id)
            ->andReturn([$friendship]);

        $this->friendshipRepository
            ->shouldReceive('delete')
            ->once()
            ->with($friendship);

        $this->friendshipManage->removeFriend($user1, $user2);

        // Verificação do comportamento esperado
        $this->assertTrue(true); // Se necessário, ajuste isso conforme o comportamento esperado.
    }

    public function testListFriends()
    {
        $user = User::factory()->create();

        $friendship1 = new Friendship(['friend_id' => 1]);
        $friendship2 = new Friendship(['friend_id' => 2]);

        $this->friendshipRepository
            ->shouldReceive('findByUserId')
            ->once()
            ->with($user->id)
            ->andReturn([$friendship1, $friendship2]);

        $friendIds = $this->friendshipManage->listFriends($user);

        $this->assertEquals([1, 2], $friendIds);
    }

    public function testGetFriendshipStatus()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $friendship = new Friendship([
            'user_id' => $user1->id,
            'friend_id' => $user2->id,
            'status' => 'accepted',
        ]);

        $this->friendshipRepository
            ->shouldReceive('findByUserId')
            ->once()
            ->with($user1->id)
            ->andReturn([$friendship]);

        $status = $this->friendshipManage->getFriendshipStatus($user1, $user2);

        $this->assertEquals('accepted', $status);
    }
}
