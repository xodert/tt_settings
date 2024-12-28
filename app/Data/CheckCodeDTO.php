<?php

namespace App\Data;

use Spatie\LaravelData\Data;

final class CheckCodeDTO extends Data
{
    public int $user_id;
    public int $confirmation_type_id;
    public int $source_id;
    public string $action;

    public string $code;
}
