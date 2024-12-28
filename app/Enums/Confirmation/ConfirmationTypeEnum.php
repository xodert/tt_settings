<?php

namespace App\Enums\Confirmation;

use App\Services\MessageSenders\Email\EmailMessageSender;
use App\Services\MessageSenders\Telegram\TelegramMessageSender;
use App\Traits\EnumTrait;
use Nette\NotImplementedException;

enum ConfirmationTypeEnum: string
{
    use EnumTrait;

    case SMS = 'sms';

    case EMAIL = 'email';

    case TELEGRAM = 'telegram';

    /**
     * @return string
     */
    public function getClass(): string
    {
        return match ($this) {
            self::TELEGRAM => TelegramMessageSender::class,
            self::EMAIL => EmailMessageSender::class,
            default => throw new NotImplementedException(),
        };
    }

    /**
     * @param array $data
     * @return array
     */
    public function prepareBody(array $data): array
    {
        return match ($this) {
            self::TELEGRAM => [],
            default => throw new NotImplementedException(),
        };
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return match ($this) {
            self::TELEGRAM => 'Telegram',
            self::EMAIL => 'Email',
            self::SMS => 'SMS',
            default => throw new NotImplementedException(),
        };
    }

    /**
     * @return string
     */
    public function getUserField(): string
    {
        return match ($this) {
            self::TELEGRAM => 'telegram_id',
            self::EMAIL => 'email',
            self::SMS => 'phone'
        };
    }
}
