<?php

namespace App\Services\Mvsc\Models;

use App\Models\User;
use App\Services\Mvsc\Contracts\ValidationRules;
use Illuminate\Database\Eloquent;

/**
* @mixin \Eloquent
*/
abstract class MvscBase extends Eloquent\Model implements ValidationRules
{
    protected ?string $formInputName = null;

    protected ?array $formValidationRules = [];

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

    public function getFormInputName(): string
    {
        if (!empty($this->formInputName))
        {
            return $this->formInputName;
        }

        $parts = explode('\\', static::class);

        if (!is_array($parts))
        {
            $parts = [$parts];
        }

        $this->formInputName = strtolower(array_pop($parts));

        return $this->formInputName;
    }

    public function setFormValidationRules(array $rules): static
    {
        $this->formValidationRules = $rules;

        return $this;
    }

    public function addFormValidationRules(array $additionalRules): static
    {
        $this->formValidationRules += $additionalRules;

        return $this;
    }

    public function getFormValidationRules(?array $additionalRules = []): array
    {
        return $this->formValidationRules + $additionalRules;
    }

    /**
     * This method is intended to be overridden by descendants when they want
     * to create their related models with one form input.
     */
    public function createDependents(array $attributes = []): static {
        return $this;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(string $action, User $user)
    {
        //@todo implement authorize logic
        return true;
    }
}
