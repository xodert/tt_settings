<?php

namespace App\Services\MessageSenders\Email;

use App\Enums\Confirmation\ConfirmationStatusEnum;
use App\Mail\CodeMail;
use App\Services\MessageSenders\AbstractMessageSender;
use Mail;

class EmailMessageSender extends AbstractMessageSender implements EmailMessageSenderInterface
{

    /**
     * @return void
     */
    public function send(): void
    {
        $email = $this->confirmation->user->email;
        $message = 'Yours confirmation code: ' . $this->confirmation->code;

        Mail::to($email)->send(new CodeMail($message));

        $this->confirmation->update(['message' => $message, 'status' => ConfirmationStatusEnum::DELIVERED->value]);
    }
}