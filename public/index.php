<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use TelegramBot\Api\Client;
use Bot\Command\PingCommand;
use Bot\Command\StartCommand;
use Bot\Message\VideoReceived;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$dotenv->required(['TELEGRAM_BOT_NAME', 'TELEGRAM_TOKEN']);

$botName = $_ENV['TELEGRAM_BOT_NAME'];
$token = $_ENV['TELEGRAM_TOKEN'];

$commands = [
    'start' => StartCommand::class,
    'ping' => PingCommand::class,
];
$messages = [
    VideoReceived::class,
];

try {
    $bot = new Client($token);

    foreach ($commands as $name => $command) {
        //Handle /$name command
        $bot->command($name, Closure::fromCallable(new $command($bot)));
    }

    foreach ($messages as $message) {
        // Handle any messages
        $bot->on(Closure::fromCallable(new $message($bot)), function () {
            return true;
        });
    }

    $bot->run();
} catch (\TelegramBot\Api\Exception $e) {
    // create a log channel
    $log = new Logger('Telegram Bot');
    $log->pushHandler(new StreamHandler('../var/error.log', Logger::WARNING));
    // Silence is golden!
    // log telegram errors
    $log->error($e->getMessage());
} catch (Exception $e) {
    // create a log channel
    $log = new Logger('System');
    $log->pushHandler(new StreamHandler('../var/error.log', Logger::WARNING));
    // Silence is golden!
    // log application errors
    // echo $e->getMessage();
    $log->error($e->getMessage());
}
