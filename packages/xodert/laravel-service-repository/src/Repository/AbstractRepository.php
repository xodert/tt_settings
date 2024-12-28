<?php

namespace Xodert\ServiceRepository\Repository;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use stdClass;
use Xodert\ServiceRepository\DataMapper\DefaultEntity;
use Xodert\ServiceRepository\Enums\RepositoryParamEnum;

abstract class AbstractRepository implements AbstractRepositoryInterface
{
    protected string $entity = DefaultEntity::class;

    /**
     * @var array
     */
    protected array $params = [];

    /**
     * @param Model $model
     */
    public function __construct(
        protected Model $model
    ) {}

    /**
     * @return string
     */
    public function entity(): string
    {
        return $this->entity;
    }

    /**
     * @param int      $perPage
     * @param string[] $columns
     * @param string   $pageName
     * @param int|null $page
     * @param bool     $toBase
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], string $pageName = 'page', ?int $page = null, bool $toBase = false): LengthAwarePaginator
    {
        return $this->newQuery()
            ->when($toBase, fn(Builder $q) => $q->toBase())
            ->paginate($perPage, $columns, $pageName, $page);
    }

    /**
     * @return Builder
     */
    protected function newQuery(): Builder
    {
        return $this->applyQueryParams(
            $this->model::query()
        );
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    protected function applyQueryParams(Builder $query): Builder
    {
        foreach (RepositoryParamEnum::cases() as $param) {
            if (isset($this->params[$param->value])) {
                $query->{$param->value}(...$this->params[$param->value]);
            }
        }

        return $query;
    }

    /**
     * @param array $params
     * @return self
     */
    public function setQueryParams(array $params): self
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @param string $entity
     * @return self
     */
    public function setEntity(string $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @param int    $perPage
     * @param array  $columns
     * @param string $pageName
     * @param null   $page
     * @param bool   $toBase
     * @return Paginator
     */
    public function simplePaginate(int $perPage = 15, array $columns = ['*'], string $pageName = 'page', $page = null, bool $toBase = false): Paginator
    {
        return $this->newQuery()
            ->when($toBase, fn(Builder $q) => $q->toBase())
            ->simplePaginate(
                $perPage,
                $columns,
                $pageName,
                $page,
            );
    }

    /**
     * @param int  $id
     * @param bool $toBase
     * @return Model|stdClass|null
     */
    public function firstById(int $id, bool $toBase = false): Model|stdClass|null
    {
        return $this->first($id, toBase:$toBase);
    }

    /**
     * @param mixed  $value
     * @param string $column
     * @param bool   $toBase
     * @return Model|stdClass|null
     */
    public function first(mixed $value, string $column = 'id', bool $toBase = false): Model|stdClass|null
    {
        $qb = $this->newQuery()
            ->when($toBase, fn(Builder $q) => $q->toBase());

        return is_array($value)
            ? $qb->where($value)->first()
            : $qb->where($column, '=', $value)->first();
    }

    /**
     * @param array  $fillable
     * @param string $orderField
     * @param string $orderType
     * @return Collection
     */
    public function where(array $fillable, string $orderField = 'id', string $orderType = 'desc'): Collection
    {
        return $this->newQuery()->where($fillable)
            ->orderBy($orderField, $orderType)
            ->get();
    }

    /**
     * @param array $select
     * @param bool  $base
     * @return Collection
     */
    public function get(array $select = ['*'], bool $base = false): Collection
    {
        return $this->newQuery()
            ->when($base, fn(Builder $q) => $q->toBase())
            ->get($select);
    }

    /**
     * @param string $slug
     * @return stdClass|null
     */
    public function firstBySlug(string $slug): ?Model
    {
        return $this->newQuery()
            ->where('slug', $slug)
            ->first();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function existsById(int $id): bool
    {
        return $this->exists($id);
    }

    /**
     * @param        $value
     * @param string $column
     * @return bool
     */
    public function exists($value, string $column = 'id'): bool
    {
        $qb = $this->newQuery()->toBase();

        return is_array($value)
            ? $qb->where($value)->exists()
            : $qb->where($column, '=', $value)->exists();
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return Builder|Model
     */
    public function firstOrCreate(array $attributes = [], array $values = []): Model|Builder
    {
        return $this->newQuery()->firstOrCreate($attributes, $values);
    }

    /**
     * @param int|array $id
     * @return bool
     */
    public function destroyById(int|array $id): bool
    {
        return $this->getModel()::destroy($id);
    }

    /**
     * @return Model
     */
    public function getModel(): string
    {
        return $this->model::class;
    }

    /**
     * @param int   $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->newQuery()->find($id)->update($data);
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return bool
     */
    public function updateOrCreate(array $attributes, array $values = []): bool
    {
        return $this->newQuery()->updateOrCreate($attributes, $values);
    }

    /**
     * @param $array
     * @return mixed
     */
    public function factory($array): Factory
    {
        return $this->getModel()::factory();
    }

    /**
     * @param array $data
     * @return Model|null
     */
    public function createOrNull(array $data): ?Model
    {
        try {
            $entity = $this->getModel()::query()->create($data);
        } catch (Exception $e) {
            return null;
        }

        return $entity;
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->getModel()::create($data);
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @return Model|null
     */
    public function firstByKey(string $key, mixed $value): ?Model
    {
        return $this->newQuery()->firstWhere($key, $value);
    }

    /**
     * @param       $ids
     * @param array $columns
     * @return Collection
     */
    public function findMany($ids, array $columns = ['*']): Collection
    {
        return $this->newQuery()->findMany($ids, $columns);
    }

    /**
     * @param array $values
     * @param       $uniqueBy
     * @param       $update
     * @return int
     */
    public function upsert(array $values, $uniqueBy, $update = null): int
    {
        return $this->newQuery()
            ->upsert(
                $values,
                $uniqueBy,
                $update
            );
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @return Collection
     */
    public function getAllByKey(string $key, mixed $value): Collection
    {
        return $this->newQuery()
            ->where($key, $value)
            ->get();
    }

    /**
     * @param string $name
     * @param array  $arguments
     * @return $this|void
     */
    public function __call(string $name, array $arguments)
    {
        if (($method = RepositoryParamEnum::tryFrom($name)) !== null) {
            $this->setParam($method->value, ...$arguments);

            return $this;
        }
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @return void
     */
    protected function setParam(string $key, mixed $value): void
    {
        $this->params[$key] = $value;
    }

    /**
     * @param array $values
     * @return bool
     */
    public function insert(array $values): bool
    {
        return $this->newQuery()->insert($values);
    }
}
