<?php


use App\Chat\ChatRoom;
use App\Message\Message;
use App\Models\User;
use App\Repositories\MessageRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatRoomTest extends TestCase
{
    use RefreshDatabase;

    protected ChatRoom $chatRoom;
    protected User $mainUser;
    protected User $participant;
    protected MessageRepository $messageRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Criar o repositório de mensagens
        $this->messageRepository = new MessageRepository();

        // Criar usuários
        $this->mainUser = User::create([
            'name' => 'Main User',
            'username' => 'mainuser',
            'email' => 'mainuser@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->participant = User::create([
            'name' => 'Participant',
            'username' => 'participant',
            'email' => 'participant@example.com',
            'password' => bcrypt('password'),
        ]);

        // Criar a sala de chat com o usuário principal
        $this->chatRoom = new ChatRoom($this->mainUser, $this->messageRepository);
        $this->chatRoom->setId(1); // Definindo um ID fictício para a sala de chat
    }

    public function testCanCreateChatRoomWithMainUser()
    {
        $this->assertEquals($this->mainUser, $this->chatRoom->getMainUser());
        $this->assertNull($this->chatRoom->getParticipant());
    }

    public function testCanAddParticipant()
    {
        $this->chatRoom->addParticipant($this->participant);
        $this->assertEquals($this->participant, $this->chatRoom->getParticipant());
    }

    public function testCannotAddMoreThanOneParticipant()
    {
        $this->chatRoom->addParticipant($this->participant);
        $this->expectException(\Exception::class);
        $this->chatRoom->addParticipant(User::create([
            'name' => 'Another User',
            'username' => 'anotheruser',
            'email' => 'anotheruser@example.com',
            'password' => bcrypt('password'),
        ]));
    }

    public function testCanRemoveParticipant()
    {
        $this->chatRoom->addParticipant($this->participant);
        $this->chatRoom->removeParticipant();
        $this->assertNull($this->chatRoom->getParticipant());
    }

    public function it_can_send_a_message()
    {
        // Cria um usuário principal
        $mainUser = User::factory()->create();

        // Cria uma sala de chat e define um ID
        $chatRoom = ChatRoom::create([
            'name' => 'Test Chat Room',
            'main_user_id' => $mainUser->id,
        ]);
        $chatRoom->setId(1); // Define o ID da sala de chat para o teste

        // Envia uma mensagem
        $response = $this->actingAs($mainUser)->post('/api/chat/1/messages', [
            'content' => 'Hello, world!',
        ]);

        // Verifica se a resposta é bem-sucedida
        $response->assertStatus(200);

        // Verifica se a mensagem foi salva no banco de dados
        $this->assertDatabaseHas('messages', [
            'content' => 'Hello, world!',
            'sender_id' => $mainUser->id,
            'chat_id' => $chatRoom->id,
        ]);
    }

    public function testCanGetMessages()
    {
        $this->chatRoom->sendMessage('Hello, world!', $this->mainUser);

        // Recupera as mensagens da sala de chat
        $messages = $this->chatRoom->getMessages();

        // Verifica se há exatamente uma mensagem
        $this->assertCount(1, $messages);

        // Verifica o conteúdo da mensagem
        $this->assertEquals('Hello, world!', $messages[0]->content);
    }

    public function testCanGetMainUser()
    {
        $this->assertEquals($this->mainUser, $this->chatRoom->getMainUser());
    }

    public function testCanGetParticipant()
    {
        $this->chatRoom->addParticipant($this->participant);
        $this->assertEquals($this->participant, $this->chatRoom->getParticipant());
    }
}
