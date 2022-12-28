<?php

namespace App\Services\Mvsc\Models;

use App\Models\User;
use App\Services\Mvsc\Contracts\ValidationRules;
use App\Services\Mvsc\Requests\Request;
use App\Services\Mvsc\SystemNotifications\MessageQueue;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\Validator as ValidatorFactory;
use RuntimeException;

/**
* @mixin \Eloquent
*/
abstract class MvscBase extends Eloquent\Model implements ValidationRules
{
    protected ?string $formInputName = null;

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
        if(!empty($this->formInputName)){
            return $this->formInputName;
        }

        $parts = explode('\\', static::class);

        if (!is_array($parts)){
            $parts = ['form'];
        }

        $this->formInputName = strtolower(array_pop($parts));
        return $this->formInputName;
    }

    protected function validateRequestInput(Request $request, MessageQueue $msgQue): array
    {
        $validator = ValidatorFactory::make(
            $this->request->all()[$this->getFormInputName()],
            $this->getFormValidationRules()
        );

        if ($validator->fails())
        {
            $this->logErrorsToQueue($validator->errors()->toArray());
            throw new RuntimeException(code:422);
        }

        return $validator->safe()->all();
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
