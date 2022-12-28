<?php

declare(strict_types=1);

namespace App\Services\Mvsc\Models;

use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\App;

class Collection extends Eloquent\Collection
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
}
