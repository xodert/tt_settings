<?php

namespace App\Facades\Telegram;

use App\Services\Telegram\TelegramService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static TelegramService setToken(string $token)
 * @method static string getToken()
 * @method static TelegramService setBot(string $bot)
 * @method static string getBot()
 * @method static mixed setWebhook(array $params)
 * @method static mixed getWebhookInfo()
 * @method static mixed sendMessage(array $params)
 */
class Telegram extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TelegramService::class;
    }
}