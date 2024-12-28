<?php

namespace App\Enums\Telegram;

use App\Traits\EnumTrait;

enum TelegramMethodEnum: string
{
    use EnumTrait;

    const REQUIRED_CHAT_RULES = [
        'chat_id' => ['required', 'integer']
    ];

    case GET_WEBHOOK_INFO = 'getWebhookInfo';
    case SET_WEBHOOK = 'setWebhook';
    case SEND_MESSAGE = 'sendMessage';

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function validateRules(): array
    {
        return match ($this) {
            self::SEND_MESSAGE => array_merge(
                self::REQUIRED_CHAT_RULES, [
                'text' => ['required', 'string']
            ]),
            default => []
        };
    }
}
