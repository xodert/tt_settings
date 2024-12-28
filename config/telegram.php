<?php

use App\Telegram\Commands\AdminCommand;
use App\Telegram\Commands\CourseCommand;
use App\Telegram\Commands\CourseMessageCommand;
use App\Telegram\Commands\PaymentCommand;
use App\Telegram\Commands\StartCommand;
use App\Telegram\Commands\TestCommand;
use App\Telegram\Commands\UploadCommand;

return [
    /**
     * Default bot
     */
    'default' => 'main',

    /**
     * Multi bots system
     */
    'bots' => [
        /**
         * Slug for main bot
         */
        'main' => [
            'username' => env('TELEGRAM_BOT_USERNAME'),
            /**
             * Bot token
             */
            'token' => env('TELEGRAM_TOKEN'),

            /**
             * Bot webhook url
             */
            'webhook' => [
                'url' => env('TELEGRAM_WEBHOOK_URL'),
                'certificate' => env('TELEGRAM_WEBHOOK_CERTIFICATE'),
            ],
        ]
    ],
];
