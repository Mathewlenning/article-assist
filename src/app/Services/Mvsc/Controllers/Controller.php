<?php

namespace App\Services\Mvsc\Controllers;

use App\Services\Mvsc\Contracts\SingleTaskController;
use App\Services\Mvsc\Contracts\SystemNotifications;
use App\Services\Mvsc\Models\MvscBase;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Services\Mvsc\Requests\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator as ValidatorFactory;
use Illuminate\Validation\Validator;
use RuntimeException;


abstract class Controller extends BaseController implements SingleTaskController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    protected ?SingleTaskController $subController = null;

    public function __construct(
        protected Container $app,
        protected Request $request,
        protected SystemNotifications $msgQue
    ) {
    }

    public function setSubController(?SingleTaskController $controller = null): static
    {
        $this->subController = $controller;
        return $this;
    }

    public function execute(): bool
    {
        return $this->executeSubController();
    }

    protected function executeSubController(): bool
    {
        if (!$this->subController instanceof SingleTaskController) {
            return true;
        }

        return $this->subController->execute();
    }

    public function getResponse(): mixed
    {
        return $this->getSubControllerResponse();
    }

    protected function getSubControllerResponse(): mixed
    {
        if (!$this->subController instanceof SingleTaskController) {
            return null;
        }

        return $this->subController->getResponse();
    }

    protected function getModel(string $name = '', ?int $id = null): ?Model
    {
        if (empty($name)) {
            $name = $this->request->getView();
        }

        $model = $this->request->getModel($name);

        if ($model === null || $id === null) {
            return $model;
        }

        return $model->findOrNew($id);
    }

    protected function logErrorsToQueue(array $errors)
    {
        foreach ($errors AS $errorGroup)
        {
            foreach ($errorGroup AS $msg)
            {
                $this->msgQue->addMessage($msg, 'errors');
            }
        }
    }
}
