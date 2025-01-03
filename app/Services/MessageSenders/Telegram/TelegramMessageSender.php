<?php

namespace App\Services\MessageSenders\Telegram;

use App\Enums\Confirmation\ConfirmationStatusEnum;
use App\Facades\Telegram\Telegram;
use App\Services\MessageSenders\AbstractMessageSender;

final class TelegramMessageSender extends AbstractMessageSender implements TelegramMessageSenderInterface
{
    /**
     * @return void
     */
    public function send(): void
    {
        $chatId = $this->confirmation->user->telegram_id;
        $message = 'Yours confirmation code: ' . $this->confirmation->code;

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $message
        ]);

        $this->confirmation->update(['message' => $message, 'status' => ConfirmationStatusEnum::DELIVERED->value]);
    }
}