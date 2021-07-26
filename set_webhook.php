<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use TelegramBot\Api\BotApi;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ );
$dotenv->load();
$dotenv->required(['TELEGRAM_BOT_NAME', 'TELEGRAM_TOKEN']);

$botName = $_ENV['TELEGRAM_BOT_NAME'];
$token = $_ENV['TELEGRAM_TOKEN'];

$webhookUrl = $argv[1] ?? '';

try {
    $bot = new BotApi($token);

    $bot->setWebhook($webhookUrl);
} catch (Exception $e) {
    // create a log channel
    $log = new Logger('Telegram Bot');
    $log->pushHandler(new StreamHandler('var/error.log', Logger::WARNING));

    // log telegram errors
    echo $e->getMessage();
    $log->error($e->getTraceAsString());
}
