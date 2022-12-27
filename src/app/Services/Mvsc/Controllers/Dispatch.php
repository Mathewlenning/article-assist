<?php

namespace App\Services\Mvsc\Controllers;

use App\Services\Mvsc\Contracts\SingleTaskController;
use App\Services\Mvsc\Contracts\SystemNotifications;
use Illuminate\Container\Container;
use App\Services\Mvsc\Requests\Request;
use Illuminate\Support\Facades\App;
use Throwable;

class Dispatch extends Controller
{
    public function __construct(
        Container $app,
        Request $request,
        SystemNotifications $msgQue
    ) {
        parent::__construct($app, $request, $msgQue);
    }

    public function execute(): bool
    {
        try {
            $this->setSubController(
                $this->buildTaskControllers(
                    $this->request
                ))
                ->executeSubController();

        } catch (Throwable $e){
            $this->msgQue->addMessage($e->getMessage(), 'errors');

            return false;
        }

        return true;
    }

    protected function buildTaskControllers(Request $request): SingleTaskController
    {
        $tasks = $request->getTaskList();

        // Build task in reverse order
        $tasks = array_reverse($tasks);

        $controller = null;
        $subController = null;

        foreach ($tasks AS $index => $task) {
            $controllerName = 'App\Services\Mvsc\Controllers\\' . $task;
            if (!class_exists($controllerName)) {
                continue;
            }

            /** @var SingleTaskController $controller */
            $controller = new $controllerName(
                $this->app, $this->request, $this->msgQue);

            $controller->setSubController($subController);
            $subController = $controller;
        }

        if (!$controller instanceof SingleTaskController){
            $controller = new Get($this->app, $this->request, $this->msgQue);
        }

        return $controller;
    }


    public function getResponse(): mixed
    {
        $response = $this->getSubControllerResponse();

        if (empty($response) && $this->msgQue->has('errors'))
        {
            return view('system.error',
                [
                    'msgQue' => $this->msgQue
                ]
            );
        }

        return $response;
    }
}
