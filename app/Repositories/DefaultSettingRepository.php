<?php

namespace App\Repositories;

use App\Data\SettingDTO;
use App\Models\DefaultSetting;
use App\Repositories\Interfaces\DefaultSettingRepositoryInterface as RepositoryInterface;
use Xodert\ServiceRepository\Repository\AbstractRepository as Repository;

class DefaultSettingRepository extends Repository implements RepositoryInterface
{
    protected string $entity = SettingDTO::class;

    /**
     * @param DefaultSetting $model
     * @return void
     */
    public function __construct(DefaultSetting $model)
    {
        parent::__construct($model);
    }
}
