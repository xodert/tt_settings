<?php

namespace App\Enums\Confirmation;

use App\Enums\Confirmation\Actions\ConfirmationSettingResolveEnum;

enum ConfirmationResolveEnum: string
{
    case SETTINGS = 'settings';

    /**
     * @return string
     */
    public function getEnum(): string
    {
        return match ($this) {
            self::SETTINGS => ConfirmationSettingResolveEnum::class,
        };
    }
}
