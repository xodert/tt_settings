<?php

namespace App\Data;

use Spatie\LaravelData\Data;

final class TelegramInfoDTO extends Data
{
    public int $telegram_id;
    public string $telegram_token;
    public string $message;
}
