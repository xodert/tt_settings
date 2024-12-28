<?php

namespace App\Services;

use App\Enums\Confirmation\ConfirmationTypeEnum;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Xodert\ServiceRepository\Service\AbstractService as Service;

class UserService extends Service
{
    /**
     * @param UserRepositoryInterface $repository
     * @return void
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getAvailableConfirmationTypes(int $userId): Collection
    {
        $user = $this->firstById($userId);

        return collect(ConfirmationTypeEnum::cases())
            ->filter(fn(ConfirmationTypeEnum $enum) => $user->{$enum->getUserField()})
            ->map(fn(ConfirmationTypeEnum $enum) => ['name' => $enum->getName(), 'alias' => $enum->value]);
    }
}
