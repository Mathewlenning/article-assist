<?php

namespace App\Services\Mvsc\Controllers;

use App\Services\Mvsc\Models\MvscBase;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;

/**
 * Handles CRUD Create operations
 */
class Post extends Controller
{
    protected ?MvscBase $model = null;

    public function execute(): bool
    {
        $model = $this->getModel();
        $request = $this->request;

        if (!$model->authorize('create', $request->user()))
        {
            throw new AuthorizationException(code: 401);
        }

        $attributes = $request->validateRequest($model);
        $this->model = $model->create($attributes)->createDependents($attributes);

        $this->request->getMsgQue()->addMessage('Record(s) created');

        return parent::execute();
    }

    public function getResponse(): mixed
    {
        if (empty($this->model->getKey()))
        {
            return parent::getResponse();
        }

        return new RedirectResponse(
            $this->request->url(). '/' . $this->model->getKey(),
            303
        );
    }
}
