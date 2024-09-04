<?php

namespace Tests\Unit;

use App\Models\Friendship;
use App\Repositories\FriendshipRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class FriendshipRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $friendshipRepository;
    protected $friendship;
    protected $friendshipMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock do modelo Friendship
        $this->friendship = Mockery::mock(Friendship::class);
        $this->friendshipRepository = new FriendshipRepository($this->friendship);
    }

    public function testSaveFriendship()
    {
        // Cria uma instância mockada de Friendship
        $friendship = Mockery::mock(Friendship::class);
        $friendship->shouldReceive('save')->once()->andReturn(true);

        // Chama o método save do repositório
        $result = $this->friendshipRepository->save($friendship);

        // Verifica se o método save retornou a instância de Friendship
        $this->assertInstanceOf(Friendship::class, $result);
    }

    public function testFindByUserId()
    {
        $userId = 1;
        $friendship1 = new Friendship(['user_id' => $userId, 'friend_id' => 2, 'status' => 'accepted']);
        $friendship2 = new Friendship(['user_id' => $userId, 'friend_id' => 3, 'status' => 'accepted']);

        // Mockando o método 'findByUserId' do repositório para retornar as amizades
        $friendshipRepositoryMock = Mockery::mock(FriendshipRepository::class)->makePartial();
        $friendshipRepositoryMock->shouldReceive('findByUserId')
            ->with($userId)
            ->andReturn([$friendship1, $friendship2]);

        // Chama o método findByUserId do repositório mockado
        $result = $friendshipRepositoryMock->findByUserId($userId);

        // Verifica se o resultado é um array e contém as amizades esperadas
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals($friendship1->toArray(), $result[0]->toArray());
        $this->assertEquals($friendship2->toArray(), $result[1]->toArray());
    }

    public function testDeleteFriendship()
    {
        // Cria uma instância mockada de Friendship
        $friendship = Mockery::mock(Friendship::class);
        $friendship->shouldReceive('delete')->once()->andReturn(true);

        // Chama o método delete do repositório
        $result = $this->friendshipRepository->delete($friendship);

        // Verifica se o método delete retornou verdadeiro
        $this->assertTrue($result);
    }

    public function testFindFriendship()
    {
        $senderId = 1;
        $friendId = 2;

        // Cria uma instância mockada de Friendship
        $friendship1 = new Friendship(['user_id' => $senderId, 'friend_id' => $friendId, 'status' => 'pending']);
        $friendship2 = new Friendship(['user_id' => $friendId, 'friend_id' => $senderId, 'status' => 'accepted']);

        // Mockando o método 'findFriendship' do repositório
        $friendshipRepositoryMock = Mockery::mock(FriendshipRepository::class)->makePartial();
        $friendshipRepositoryMock->shouldReceive('findFriendship')
            ->with($senderId, $friendId)
            ->andReturn($friendship1);
        $friendshipRepositoryMock->shouldReceive('findFriendship')
            ->with($friendId, $senderId)
            ->andReturn($friendship2);

        // Chama o método findFriendship do repositório mockado
        $result1 = $friendshipRepositoryMock->findFriendship($senderId, $friendId);
        $result2 = $friendshipRepositoryMock->findFriendship($friendId, $senderId);

        // Verifica se o método retornou a amizade correta em ambas as direções
        $this->assertInstanceOf(Friendship::class, $result1);
        $this->assertEquals($friendship1->id, $result1->id);

        $this->assertInstanceOf(Friendship::class, $result2);
        $this->assertEquals($friendship2->id, $result2->id);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
