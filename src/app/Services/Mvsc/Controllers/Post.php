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
        /** @var MvscBase $model */
        $model = $this->getModel();

        if (!$model->authorize('create', $this->request->user()))
        {
            throw new AuthorizationException(code: 401);
        }

        $attributes = $this->validateRequestInput($this->request, $model);
        $this->model = $model->create($attributes)->createDependents($attributes);

        $this->msgQue->addMessage('Record(s) created');

        return $this->executeSubController();
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
