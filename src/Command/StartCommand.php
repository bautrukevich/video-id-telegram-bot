<?php

declare(strict_types=1);

namespace Bot\Command;

use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Message;

final class StartCommand
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function __invoke(Message $message)
    {
        $this->client->sendMessage(
            $message->getChat()->getId(),
            'Just drag and drop file to bot or sent video and you will receive a file id',
        );
    }
}
