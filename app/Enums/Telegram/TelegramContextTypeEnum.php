<?php

namespace App\Enums\Telegram;

use App\Traits\EnumTrait;

enum TelegramContextTypeEnum: string
{
    use EnumTrait;

    case MESSAGE = 'message';

    /**
     * @return array
     */
    public static function telegramContext(): array
    {
        return [
            'message',
            'edited_message',
            'channel_post',
            'edited_channel_post',
            'inline_query',
            'chosen_inline_result',
            'callback_query',
            'shipping_query',
            'pre_checkout_query',
            'poll',
            'my_chat_member',
        ];
    }
}
