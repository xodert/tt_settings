<?php

namespace App\Enums\Confirmation;

use App\Traits\EnumTrait;

enum ConfirmationStatusEnum: string
{
    use EnumTrait;

    const EXPIRED_TIME = 1; // Minutes

    case EXPIRED = 'expired';
    case PENDING = 'pending';
    case DELIVERED = 'delivered';
    case RESOLVING = 'resolving';
    case RESOLVED = 'resolved';
}
