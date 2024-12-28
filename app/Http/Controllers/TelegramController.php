<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function link(Request $request)
    {
        $user = $request->user();

        if (isset($user->telegram_id)) {
            return response()->json([
                'success' => false,
                'message' => 'You are already linked Telegram.',
            ], 422);
        }

        $telegramToken = $user->telegram_token ?? md5(json_encode([
            'user_id' => $user->id,
            'telegram_token' => $user->telegram_token,
        ]));

        if (empty($user->telegram_token)) {
            $user->update(['telegram_token' => $telegramToken]);
        }

        $telegramBotUsername = config('telegram.bots.main.username');

        $link = 'https://t.me/' . $telegramBotUsername . '?' . http_build_query(['start' => $telegramToken]);

        return response()->json([
            'success' => true,
            'data' => [
                'link' => $link
            ],
        ]);
    }
}
