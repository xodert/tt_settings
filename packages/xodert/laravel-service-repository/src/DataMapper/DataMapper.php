<?php

namespace Xodert\ServiceRepository\DataMapper;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;
use stdClass;
use Throwable;

class DataMapper
{
    /**
     * @param Collection|EloquentCollection|LengthAwarePaginator|Paginator|Model|array|stdClass $data
     * @param string                                                                            $entity
     */
    public function __construct(
        protected Collection|EloquentCollection|LengthAwarePaginator|Paginator|Model|array|stdClass $data = [],
        protected string                                                                            $entity = DefaultEntity::class,
    ) {}

    /**
     * @return Collection|mixed
     */
    public function transform(): mixed
    {
        return $this->isCollection()
            ? $this->toCollection($this->data)
            : $this->toEntity($this->data);
    }

    /**
     * @return bool
     */
    protected function isCollection(): bool
    {
        return $this->data instanceof Collection
            || $this->data instanceof EloquentCollection
            || $this->data instanceof Paginator
            || (is_array($this->data) && array_is_list($this->data));
    }

    /**
     * @param Collection|EloquentCollection|LengthAwarePaginator|Paginator|array $data
     * @return Collection|Paginator
     */
    public function toCollection(Collection|EloquentCollection|LengthAwarePaginator|Paginator|array $data): Collection|Paginator
    {
        if ($data instanceof Paginator) {
            return $this->prepareToPaginate($data);
        }

        return $this->prepareForCollection($data ?? $this->data)->map(function ($item) {
            try {
                return $this->toEntity($item);
            } catch (Throwable $exception) {
                report($exception);

                return $item;
            }
        });
    }

    public function prepareToPaginate(Paginator|LengthAwarePaginator $data): Paginator|LengthAwarePaginator
    {
        $item = data_get($data->items(), 0);

        if ($item === null) {
            return $data;
        }

        $additionalArgs = [];

        $items = collect($data->items())->map(fn($item) => $this->toEntity($item));

        if ($data instanceof LengthAwarePaginator) {
            $additionalArgs = [
                'total' => $data->total()
            ];
        }

        return new ($data::class)(...array_merge([
                'items' => $items,
                'perPage' => $data->perPage(),
                'currentPage' => $data->currentPage(),
                'options' => $data->getOptions()
            ], $additionalArgs)
        );
    }

    /**
     * @param Model|stdClass $data
     * @return mixed
     */
    public function toEntity(Model|stdClass $data): mixed
    {
        $parentClass = get_parent_class($this->entity);
        if ($parentClass === Data::class) {
            return $this->entity::from($data instanceof Model ? $data->toArray() : (array) $data);
        }

        return new $this->entity(
            $data instanceof Model ? $data->toArray() : (array) $data
        );
    }

    /**
     * @param Collection|EloquentCollection|Paginator|array $data
     * @return Collection
     */
    protected function prepareForCollection(Collection|EloquentCollection|Paginator|array $data): Collection
    {
        if ($data instanceof EloquentCollection || $data instanceof Paginator) {
            return $data->toBase();
        } elseif (is_array($data)) {
            return collect($data);
        }

        return $data;
    }
}
