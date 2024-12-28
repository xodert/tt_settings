<?php

namespace Xodert\ServiceRepository\Repository;

use Xodert\ServiceRepository\DataMapper\DataMapper;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use stdClass;

class RepositoryManager
{
    /**
     * @param AbstractRepositoryInterface $repository
     */
    public function __construct(
        protected AbstractRepositoryInterface $repository,
    ) {}

    /**
     * @param string $name
     * @param array  $arguments
     * @return void
     */
    public function __call(string $name, array $arguments)
    {
        $response = $this->repository->{$name}(...$arguments);

        if ($this->isToTransform($response) && config('service-repository.entity')) {
            return $this->transform($response);
        }

        return $response;
    }

    /**
     * @param $response
     * @return bool
     */
    protected function isToTransform($response): bool
    {
        return $response instanceof Model
            || $response instanceof EloquentCollection
            || $response instanceof Collection
            || $response instanceof LengthAwarePaginator
            || $response instanceof Paginator
            || $response instanceof stdClass
            || is_array($response);
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    public function transform(Collection|EloquentCollection|LengthAwarePaginator|Paginator|Model|array|stdClass $data): mixed
    {
        return (new DataMapper($data, $this->repository->entity()))
            ->transform();
    }
}
