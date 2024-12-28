<?php

namespace App\Observers;

use App\Models\Confirmation;

class ConfirmationObserver
{
    /**
     * @param Confirmation $confirmation
     * @return void
     */
    public function created(Confirmation $confirmation): void
    {
        (new ($confirmation->confirmationType->alias->getClass())($confirmation))->send();
    }
}
