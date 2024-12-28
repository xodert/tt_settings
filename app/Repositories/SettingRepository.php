<?php

namespace App\Repositories;

use App\Data\SettingDTO;
use App\Models\Setting;
use App\Repositories\Interfaces\SettingRepositoryInterface as RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Xodert\ServiceRepository\Repository\AbstractRepository as Repository;

class SettingRepository extends Repository implements RepositoryInterface
{
    protected string $entity = SettingDTO::class;

    /**
     * @param Setting $model
     * @return void
     */
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array  $ids
     * @param string $key
     * @param mixed  $value
     * @return Model|null
     */
    public function firstByKeyOfAnyIds(array $ids, string $key, mixed $value): ?Model
    {
        return $this->newQuery()->whereIn('id', $ids)
            ->where($key, '=', $value)
            ->first();
    }
}
