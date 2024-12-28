<?php

namespace App\Repositories;

use App\Models\Source;
use App\Repositories\Interfaces\SourceRepositoryInterface as RepositoryInterface;
use Xodert\ServiceRepository\Repository\AbstractRepository as Repository;

class SourceRepository extends Repository implements RepositoryInterface
{
	/**
	 * @param Source $model
	 * @return void
	 */
	public function __construct(Source $model)
	{
		parent::__construct($model);
	}
}
