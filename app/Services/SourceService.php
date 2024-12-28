<?php

namespace App\Services;

use App\Repositories\Interfaces\SourceRepositoryInterface;
use Xodert\ServiceRepository\Service\AbstractService as Service;

class SourceService extends Service
{
	/**
	 * @param SourceRepositoryInterface $repository
	 * @return void
	 */
	public function __construct(SourceRepositoryInterface $repository)
	{
		parent::__construct($repository);
	}
}
