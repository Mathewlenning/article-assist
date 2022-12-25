<?php

declare(strict_types=1);

namespace App\Models;

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
    public function findOrNew(mixed $key): Eloquent\Model
    {
        $model = $this->find($key);

        if ($model instanceof $this->modelClass) {
            return $model;
        }

        return App::make($this->modelClass::class);
    }
}
