<?php

namespace App\Models;

use App\Interfaces\ValidationRules;
use Illuminate\Database\Eloquent;

abstract class Base extends Eloquent\Model implements ValidationRules
{
    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return Collection
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($this, $models);
    }
}
