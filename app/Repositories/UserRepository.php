<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface as RepositoryInterface;
use Xodert\ServiceRepository\Repository\AbstractRepository as Repository;

class UserRepository extends Repository implements RepositoryInterface
{
	/**
	 * @param User $model
	 * @return void
	 */
	public function __construct(User $model)
	{
		parent::__construct($model);
	}
}
