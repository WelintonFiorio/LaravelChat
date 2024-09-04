<?php


use App\Message\Message;
use App\Repositories\MessageRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected MessageRepository $messageRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->messageRepository = new MessageRepository();
    }

    public function testCanSaveAMessage()
    {
        $user = \App\Models\User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $message = new Message([
            'content' => 'Hello, world!',
            'sender_id' => $user->id,
        ]);

        $savedMessage = $this->messageRepository->save($message);

        $this->assertDatabaseHas('messages', [
            'content' => 'Hello, world!',
            'sender_id' => $user->id,
        ]);

        $this->assertEquals('Hello, world!', $savedMessage->content);
    }

    public function testCanFindMessageById()
    {
        $user = \App\Models\User::create([
            'name' => 'Test User2',
            'username' => 'testuser2',
            'email' => 'test2@example.com',
            'password' => bcrypt('password'),
        ]);

        $message = new Message([
            'content' => 'Hello, world!',
            'sender_id' => $user->id,
        ]);

        $savedMessage = $this->messageRepository->save($message);

        $foundMessage = $this->messageRepository->find($savedMessage->id); // Alterado para usar find

        $this->assertNotNull($foundMessage);
        $this->assertEquals('Hello, world!', $foundMessage->content);
    }

    public function testReturnsNullWhenMessageNotFound()
    {
        $message = $this->messageRepository->find(999); // Alterado para usar find
        $this->assertNull($message);
    }

    public function testCanDeleteAMessage()
    {
        $user = \App\Models\User::create([
            'name' => 'Test User3',
            'username' => 'testuser3',
            'email' => 'test3@example.com',
            'password' => bcrypt('password'),
        ]);

        $message = new Message([
            'content' => 'To be deleted',
            'sender_id' => $user->id,
        ]);

        $savedMessage = $this->messageRepository->save($message);
        $this->messageRepository->delete($savedMessage->id);

        $this->assertDatabaseMissing('messages', [
            'content' => 'To be deleted',
            'sender_id' => $user->id,
        ]);
    }

    public function testReturnsFalseWhenDeletingANonExistentMessage()
    {
        $result = $this->messageRepository->delete(999); // ID que não existe
        $this->assertFalse($result);
    }
}
