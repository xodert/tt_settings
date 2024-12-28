<?php

namespace App\Services;

use App\Repositories\Interfaces\SettingRepositoryInterface;
use stdClass;
use Xodert\ServiceRepository\Service\AbstractService as Service;

/**
 * @method stdClass|null firstByKeyOfAnyIds(array $ids, string $key, mixed $value)
 */
class SettingService extends Service
{
    /**
     * @param SettingRepositoryInterface $repository
     * @return void
     */
    public function __construct(SettingRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
