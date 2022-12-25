<?php

namespace App\Services\Mvsc\Models;

use App\Services\Mvsc\Contracts\ValidationRules;
use Illuminate\Database\Eloquent;

abstract class MvscBase extends Eloquent\Model implements ValidationRules
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
