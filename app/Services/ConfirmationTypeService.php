<?php

namespace App\Services;

use App\Repositories\Interfaces\ConfirmationTypeRepositoryInterface;
use Xodert\ServiceRepository\Service\AbstractService as Service;

class ConfirmationTypeService extends Service
{
	/**
	 * @param ConfirmationTypeRepositoryInterface $repository
	 * @return void
	 */
	public function __construct(ConfirmationTypeRepositoryInterface $repository)
	{
		parent::__construct($repository);
	}
}
