<?php

namespace App\Actions\Confirmation;

use App\Enums\Confirmation\ConfirmationStatusEnum;
use App\Services\ConfirmationService;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\AsJob;

class ChangeConfirmationStatusAction
{
    use AsAction, AsJob;

    public function __construct(
        protected ConfirmationService $confirmationService
    ) {}

    /**
     * @param int                    $confirmationId
     * @param ConfirmationStatusEnum $enum
     * @return void
     */
    public function asJob(int $confirmationId, ConfirmationStatusEnum $enum): void
    {
        $this->handle($confirmationId, $enum);
    }

    /**
     * @param int                    $confirmationId
     * @param ConfirmationStatusEnum $enum
     * @return void
     */
    public function handle(int $confirmationId, ConfirmationStatusEnum $enum): void
    {
        $this->confirmationService->update($confirmationId, [
            'status' => $enum->value,
        ]);
    }
}
