<?php

namespace App\Services;

use App\Repositories\Interfaces\DefaultSettingRepositoryInterface;
use Illuminate\Support\Collection;
use Xodert\ServiceRepository\Service\AbstractService as Service;

class DefaultSettingService extends Service
{
    /**
     * @param DefaultSettingRepositoryInterface $repository
     * @return void
     */
    public function __construct(DefaultSettingRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @return Collection
     */
    public function getAllDefaultSettings(): Collection
    {
        $this->setQueryParams([
            'select' => ['id', 'key', 'value', 'label']
        ]);

        return $this->get();
    }
}
