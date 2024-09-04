<?php


use App\Factories\TextMessageFactory;
use App\Message\TextMessage;
use App\Models\User;
use DateTime;
use PHPUnit\Framework\TestCase;

class TextMessageFactoryTest extends TestCase
{
    /**
     * Testa a criação de uma instância de TextMessage usando a TextMessageFactory.
     *
     * @return void
     */
    public function testCreateTextMessage()
    {
        // Criando um usuário mock para a mensagem
        $user = $this->createMock(User::class);

        // Definindo o conteúdo e o timestamp da mensagem
        $content = 'This is a test message';
        $messageId = 1;
        $timestamp = new DateTime();

        // Criando a fábrica de mensagens
        $factory = new TextMessageFactory();

        // Criando a mensagem de texto usando a fábrica
        $textMessage = $factory->create($messageId, $content, $user, $timestamp);

        // Assegurando que a mensagem criada é uma instância de TextMessage
        $this->assertInstanceOf(TextMessage::class, $textMessage);

        // Assegurando que os atributos da mensagem estão corretos
        $this->assertEquals($messageId, $textMessage->getId());
        $this->assertEquals($content, $textMessage->getContent());
        $this->assertSame($user, $textMessage->getSender());
        $this->assertSame($timestamp, $textMessage->getTimestamp());
    }
}
