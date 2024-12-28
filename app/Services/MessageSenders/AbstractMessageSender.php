<?php

namespace App\Services\MessageSenders;

use App\Models\Confirmation;

abstract class AbstractMessageSender implements AbstractMessageSenderInterface
{
    public function __construct(
        protected Confirmation $confirmation
    ) {}
}