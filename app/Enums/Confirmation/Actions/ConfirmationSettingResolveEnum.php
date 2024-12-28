<?php

namespace App\Enums\Confirmation\Actions;

use App\Actions\Settings\ToggleSettingEditAction;

enum ConfirmationSettingResolveEnum: string
{
    const SOURCE = 'settings';

    case TOGGLE_SETTING_UPDATE = 'toggle_setting_update';

    public function getClass(): string
    {
        return match ($this) {
            self::TOGGLE_SETTING_UPDATE => ToggleSettingEditAction::class,
        };
    }
}
