<?php

namespace App\Services\Mvsc\Controllers;

use App\Services\Mvsc\Contracts\SingleTaskController;
use App\Services\Mvsc\Models\MvscBase;
use Illuminate\Container\Container;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Services\Mvsc\Requests\MvscRequest;
use Illuminate\Routing\Controller as BaseController;


abstract class Controller extends BaseController implements SingleTaskController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    protected ?SingleTaskController $subController = null;

    public function __construct(
        protected Container   $app,
        protected MvscRequest $request,
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

    protected function getModel(string $name = '', ?int $id = null): ?MvscBase
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
}
