<?php

namespace App\Services\Mvsc\Controllers;

use App\Services\Mvsc\Config;
use App\Services\Mvsc\Contracts\SingleTaskController;
use App\Services\Mvsc\Contracts\SystemNotifications;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;


abstract class Controller extends BaseController implements SingleTaskController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    protected ?SingleTaskController $subController = null;

    public function __construct(
        protected Container $app,
        protected SystemNotifications $msgQue,
        protected Config $config)
    {
    }

    public function setSubController(?SingleTaskController $controller = null): static
    {
        $this->subController = $controller;
        return $this;
    }

    public function execute(Request $request): bool
    {
        return $this->executeSubController($request);
    }

    protected function executeSubController(Request $request): bool
    {
        if (!$this->subController instanceof SingleTaskController) {
            return true;
        }

        return $this->subController->execute($request);
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

    protected function getResourceModel(string $name = ''): ?Model
    {
        $resourceName = 'App\Models\\'.ucfirst($name);

        if ($resourceName === ''
            || !class_exists($resourceName)) {
            return null;
        }

        return new $resourceName();
    }
}
