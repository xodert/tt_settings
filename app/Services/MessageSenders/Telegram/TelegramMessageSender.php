<?php

namespace App\Services\MessageSenders\Telegram;

use App\Enums\Confirmation\ConfirmationStatusEnum;
use App\Facades\Telegram\Telegram;
use App\Services\MessageSenders\AbstractMessageSender;

final class TelegramMessageSender extends AbstractMessageSender
{
    /**
     * @return void
     */
    public function send(): void
    {
        $chatId = $this->confirmation->user->telegram_id;
        $message = 'Ваш код подтверждения:' . $this->confirmation->code;

        $this->confirmation->update(['message' => $message, 'status' => ConfirmationStatusEnum::DELIVERED->value]);

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $message
        ]);
    }
}