<?php

namespace App\Services\MessageSenders;

interface AbstractMessageSenderInterface
{
    public function send(): void;
}