<?php

namespace App\Repositories;

use App\Models\ConfirmationType;
use App\Repositories\Interfaces\ConfirmationTypeRepositoryInterface as RepositoryInterface;
use Xodert\ServiceRepository\Repository\AbstractRepository as Repository;

class ConfirmationTypeRepository extends Repository implements RepositoryInterface
{
	/**
	 * @param ConfirmationType $model
	 * @return void
	 */
	public function __construct(ConfirmationType $model)
	{
		parent::__construct($model);
	}
}
