<?php

namespace App\Services\Mvsc\Controllers;


use App\Services\Mvsc\Models\MvscBase;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class Post extends Controller
{
    public function execute(): bool
    {
        /** @var MvscBase $model */
        $model = $this->getModel();
        $validator = Validator::make($this->request->all(),
        $model->getFormValidationRules());

        if ($validator->fails())
        {
            $this->logErrorsToQueue($validator->errors()->toArray());
            throw new RuntimeException(code:422);
        }

        $validated = $validator->validated();

        $model->create($validated);

        return $this->executeSubController();
    }
}
