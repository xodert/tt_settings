<?php

namespace Xodert\ServiceRepository\Service;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Xodert\ServiceRepository\Repository\AbstractRepositoryInterface;
use Xodert\ServiceRepository\Repository\RepositoryManager;

/**
 * @method LengthAwarePaginator paginate(int $perPage = 15, array $columns = ['*'], string $pageName = 'page', ?int $page = null, bool $toBase = false)
 * @method LengthAwarePaginator simplePaginate(int $perPage = 15, array $columns = ['*'], string $pageName = 'page', ?int $page = null, bool $toBase = false)
 * @method Collection get(array $select = ['*'], bool $base = false)
 * @method Model|null firstByKey (string $key, mixed $value)
 * @method Collection getAllByKey (string $key, mixed $value)
 * @method Collection findMany ($ids, array $columns = ["*"])
 * @method int upsert(array $values, $uniqueBy, $update = null)
 * @method bool insert (array $values)
 * @method Model|null firstById(int $id)
 * @method bool existsById(int $id)
 * @method bool exists($value, string $column = 'id')
 * @method bool destroyById(int|array $id)
 * @method int update(int $id, array $data)
 * @method Model create(array $data)
 * @method Model|Builder firstOrCreate(array $attributes = [], array $values = [])
 * @method Model|Builder updateOrCreate(array $attributes, array $values = [])
 * @method Model|Builder|null createOrNull(array $attributes = [])
 *
 * @method AbstractRepositoryInterface setEntity(string $entity)
 * @method AbstractRepositoryInterface setQueryParams(array $params)
 */
abstract class AbstractService
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
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return $this->getRepository()->{$name}(...$arguments);
    }

    /**
     * @return RepositoryManager
     */
    public function getRepository(): RepositoryManager
    {
        return (new RepositoryManager($this->repository));
    }
}
