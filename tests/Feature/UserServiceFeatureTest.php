<?php


use App\Contract\UserRepositoryInterface;
use App\Models\User;
use App\Service\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserServiceFeatureTest extends TestCase
{
    use RefreshDatabase;
    protected $userService;
    protected $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->app->make(UserRepositoryInterface::class);
        $this->userService = new UserService($this->userRepository);
    }

    public function testUserCanBeRegistered()
    {
        $data = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $user = $this->userService->register($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('testuser', $user->username);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    public function testUserCanLoginWithCorrectCredentials()
    {
        $data = [
            'username' => 'testuser2',
            'email' => 'test2@example.com',
            'password' => Hash::make('password123'),
        ];

        $this->userRepository->save(new User($data));

        $user = $this->userService->login('test@example.com', 'password123');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('testuser', $user->username);
    }

    public function testUserCannotLoginWithIncorrectCredentials()
    {
        $data = [
            'username' => 'testuser3',
            'email' => 'test3@example.com',
            'password' => Hash::make('password123'),
        ];

        $this->userRepository->save(new User($data));

        $user = $this->userService->login('test@example.com', 'wrongpassword');

        $this->assertNull($user);
    }
}
