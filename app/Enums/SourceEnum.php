<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum SourceEnum: string
{
    use EnumTrait;

    case SETTINGS = 'settings';
}
