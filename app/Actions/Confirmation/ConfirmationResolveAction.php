<?php

namespace App\Actions\Confirmation;

use App\Data\ConfirmationDTO;
use App\Enums\Confirmation\ConfirmationResolveEnum;
use App\Enums\Confirmation\ConfirmationStatusEnum;
use App\Services\ConfirmationService;
use App\Services\SourceService;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ConfirmationResolveAction
{
    public function __construct(
        protected ConfirmationService $confirmationService,
        protected SourceService       $sourceService,
    ) {}

    use AsAction;

    /**
     * @param int $confirmationId
     * @return void
     * @throws Throwable
     */
    public function handle(int $confirmationId)
    {
        /** @var ?ConfirmationDTO $confirmation */
        $confirmation = $this->confirmationService->firstById($confirmationId);

        throw_if(empty($confirmation), new NotFoundHttpException());

        $source = $this->sourceService->firstById($confirmation->source_id);

        $sourceEnum = ConfirmationResolveEnum::from($source->alias);

        $actionEnum = $sourceEnum->getEnum()::from($confirmation->action);

        (($actionEnum)->getClass())::dispatch($confirmation);

        ChangeConfirmationStatusAction::dispatch($confirmationId, ConfirmationStatusEnum::RESOLVED);
    }
}
