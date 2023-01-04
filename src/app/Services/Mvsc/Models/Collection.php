<?php

declare(strict_types=1);

namespace App\Services\Mvsc\Models;

use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Collection AS EloquentCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class Collection extends EloquentCollection
{
    protected Eloquent\Model $modelClass;

    public function __construct(Eloquent\Model $modelClass, array $items = [])
    {
        parent::__construct($items);
        $this->modelClass = $modelClass;
    }

    /**
     * @param mixed $key
     * @return Eloquent\Model
     */
    public function findOrNew(mixed $key): Collection
    {
        $models = $this->find($key);

        if (!$models->isEmpty()) {
            return $models;
        }

        return new static($this->modelClass, [App::make($this->modelClass::class)]);
    }

    /**
     * Overridden to add the modelClass param to the static constructor.
     */
    public function map(callable $callback): static
    {
        return new static($this->modelClass, Arr::map($this->items, $callback));
    }
}
