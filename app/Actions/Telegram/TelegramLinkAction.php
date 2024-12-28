<?php

namespace App\Actions\Telegram;

use App\Data\TelegramInfoDTO;
use App\Events\TelegramLinked;
use App\Facades\Telegram\Telegram;
use App\Services\UserService;
use Illuminate\Validation\UnauthorizedException;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\AsJob;
use Throwable;

class TelegramLinkAction
{
    use AsAction;
    use AsJob;

    public function __construct(
        protected UserService $userService
    ) {}

    /**
     * @param TelegramInfoDTO $DTO
     * @return void
     * @throws Throwable
     */
    public function asJob(TelegramInfoDTO $DTO): void
    {
        $this->handle($DTO);
    }

    /**
     * @param TelegramInfoDTO $DTO
     * @return void
     * @throws Throwable
     */
    public function handle(TelegramInfoDTO $DTO): void
    {
        $user = $this->userService->firstByKey('telegram_token', $DTO->telegram_token);

        throw_if(empty($user), new UnauthorizedException('Telegram token is not valid.'));

        $this->userService->update(
            $user->id, ['telegram_id' => $DTO->telegram_id]
        );

        TelegramLinked::dispatch($user->id);

        Telegram::sendMessage([
            'chat_id' => $DTO->telegram_id,
            'text' => 'Вы успешно привязали Телеграм!'
        ]);
    }
}
