<?php

namespace App\Repositories;

use App\Models\UserSetting;
use App\Repositories\Interfaces\UserSettingRepositoryInterface as RepositoryInterface;
use Xodert\ServiceRepository\Repository\AbstractRepository as Repository;

class UserSettingRepository extends Repository implements RepositoryInterface
{
	/**
	 * @param UserSetting $model
	 * @return void
	 */
	public function __construct(UserSetting $model)
	{
		parent::__construct($model);
	}
}
