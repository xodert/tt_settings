<?php

namespace App\Data;

use App\Enums\Confirmation\ConfirmationStatusEnum;
use Spatie\LaravelData\Data;

final class ConfirmationDTO extends Data
{
    public int $id;

    public int $user_id;
    public int $confirmation_type_id;
    public int $source_id;
    public string $message;
    public string $code;
    public string $action;
    public array $action_data;

    public ConfirmationStatusEnum $status;
    public string $expires_at;
}
