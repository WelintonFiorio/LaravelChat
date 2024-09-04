<?php


use Tests\TestCase;
use App\Models\User;
use App\Repositories\EloquentUserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EloquentUserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new EloquentUserRepository();
    }

    public function testCanCreateUser()
    {
        $user = $this->userRepository->save(
            new User([
                'username' => 'john_doe',
                'email' => 'john@example.com',
                'password' => 'secret',
            ])
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', [
            'username' => 'john_doe',
            'email' => 'john@example.com',
        ]);
    }

    // Outros testes...
}
