<?php

namespace App\Observers;

use App\Actions\Settings\CreateDefaultUserSettingsAction;
use App\Models\User;

class UserObserver
{
    /**
     * @param User $user
     * @return void
     */
    public function created(User $user): void
    {
        CreateDefaultUserSettingsAction::dispatch($user->id);
    }
}