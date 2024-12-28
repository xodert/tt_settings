<?php

namespace App\Http\Controllers;

use App\Actions\Telegram\TelegramLinkAction;
use App\Data\TelegramInfoDTO;
use App\Enums\Telegram\TelegramContextTypeEnum;
use App\Facades\Telegram\Telegram;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    /**
     * @param Request $request
     * @param string  $botToken
     * @return void
     */
    public function __invoke(Request $request, string $botToken): void
    {
        $config = collect(config('telegram.bots'))
            ->firstWhere('token', '=', $botToken);

        if (empty($config)) {
            $config = config('telegram.bots.' . config('telegram.default'));
        }

        Telegram::setToken($config['token']);

        $context = $this->getContext();

        if ($context === TelegramContextTypeEnum::MESSAGE->value) {
            $message = $request->input('message.text');

            if (str_starts_with($message, '/start')) {
                $telegramId = $request->input('message.from.id');
                $parts = explode(' ', $message);

                $telegramToken = $parts[1] ?? '';

                TelegramLinkAction::dispatch(TelegramInfoDTO::from([
                    'telegram_id' => $telegramId,
                    'telegram_token' => $telegramToken,
                    'message' => $message
                ]));
            }
        }
    }

    /**
     * @return string
     */
    private function getContext(): string
    {
        $request = \request();

        return $request->collect()
            ->keys()
            ->intersect(TelegramContextTypeEnum::telegramContext())
            ->pop();
    }
}
