<?php

declare(strict_types=1);

namespace Bot\Message;

use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Update;

final class VideoReceived
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function __invoke(Update $update)
    {
        $message = $update->getMessage();

        $fileId = $message->getVideo()->getFileId() ?? null;
        $id = $message->getChat()->getId();

        $this->client->sendMessage($id, $fileId);
    }
}
