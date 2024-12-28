<?php

namespace App\Services;

use App\Repositories\Interfaces\UserSettingRepositoryInterface;
use Illuminate\Support\Collection;
use Xodert\ServiceRepository\Service\AbstractService as Service;

class UserSettingService extends Service
{
    /**
     * @param UserSettingRepositoryInterface $repository
     * @return void
     */
    public function __construct(UserSettingRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getAllIdsByUserId(int $userId): Collection
    {
        $this->setQueryParams([
            'select' => ['id']
        ]);

        return collect(
            $this->getAllByKey('user_id', $userId)->jsonSerialize()
        )->pluck('id');
    }
}
