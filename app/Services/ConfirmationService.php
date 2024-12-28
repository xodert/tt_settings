<?php

namespace App\Services;

use App\Repositories\Interfaces\ConfirmationRepositoryInterface;
use Xodert\ServiceRepository\Service\AbstractService as Service;

/**
 * @method int|null checkCode(int $userId, int $sourceId, int $confirmationId, string $action, string $code)
 */
class ConfirmationService extends Service
{
    /**
     * @param ConfirmationRepositoryInterface $repository
     * @return void
     */
    public function __construct(ConfirmationRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
