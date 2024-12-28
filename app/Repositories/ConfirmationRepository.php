<?php

namespace App\Repositories;

use App\Data\ConfirmationDTO;
use App\Enums\Confirmation\ConfirmationStatusEnum;
use App\Models\Confirmation;
use App\Repositories\Interfaces\ConfirmationRepositoryInterface as RepositoryInterface;
use Xodert\ServiceRepository\Repository\AbstractRepository as Repository;

class ConfirmationRepository extends Repository implements RepositoryInterface
{
    protected string $entity = ConfirmationDTO::class;

    /**
     * @param Confirmation $model
     * @return void
     */
    public function __construct(Confirmation $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int    $userId
     * @param int    $sourceId
     * @param int    $confirmationId
     * @param string $action
     * @param string $code
     * @return int|null
     */
    public function checkCode(int $userId, int $sourceId, int $confirmationId, string $action, string $code): ?Confirmation
    {
        return $this->newQuery()
            ->where('status', ConfirmationStatusEnum::DELIVERED->value)
            ->where([
                'user_id' => $userId,
                'source_id' => $sourceId,
                'action' => $action,
                'confirmation_type_id' => $confirmationId,
                'code' => $code,
            ])->first() ?? null;
    }
}
