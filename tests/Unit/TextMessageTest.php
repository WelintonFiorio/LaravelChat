<?php


use App\Message\TextMessage;
use PHPUnit\Framework\TestCase;
use App\Models\User;
use Mockery;

class TextMessageTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close(); // Fecha todos os mocks
        parent::tearDown();
    }

    public function testTextMessageCreation()
    {
        // Criando um mock para a classe User
        $userMock = Mockery::mock(User::class);

        // Definindo os atributos esperados para o TextMessage
        $content = "This is a test message";
        $messageId = 1; // Definindo um ID para a mensagem
        $timestamp = new \DateTime(); // Criando um novo DateTime para o timestamp

        // Criando a mensagem de texto
        $textMessage = new TextMessage($messageId, $content, $userMock, $timestamp);

        // Assegurando que os atributos da mensagem estão corretos
        $this->assertEquals($content, $textMessage->getContent());
        $this->assertEquals($userMock, $textMessage->getSender());
        $this->assertEquals($messageId, $textMessage->getId());
        $this->assertEquals($timestamp, $textMessage->getTimestamp());
    }
}
