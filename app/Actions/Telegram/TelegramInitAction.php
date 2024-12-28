<?php

namespace App\Actions\Telegram;

use App\Facades\Telegram\Telegram;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\AsCommand;

class TelegramInitAction
{
    use AsAction;
    use AsCommand;

    /**
     * @var string
     */
    public string $commandSignature = 'telegram:init';
    /**
     * @var string
     */
    public string $commandDescription = 'Set telegram webhook';
    /**
     * @var string
     */
    public string $commandHelp = '';

    /**
     * @return int
     */
    public function handle(): int
    {
        $data = [
            'url' => config('telegram.bots.' . config('telegram.default') . '.webhook.url')
        ];

        if (($certificate = config('telegram.bots.' . config('telegram.default') . '.webhook.certificate')) !== null) {
            $data['certificate'] = $certificate;
        }

        dump($data);

        $response = Telegram::setWebhook($data);

        dump(Telegram::getWebhookInfo());

        dump($response);

        return 0;
    }
}
