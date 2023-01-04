<?php

namespace App\Services\Mvsc\Controllers;

use App\Services\Mvsc\Contracts\SingleTaskController;

use Illuminate\Container\Container;
use App\Services\Mvsc\Requests\MvscRequest;

use Throwable;

class Dispatch extends Controller
{
    public function __construct(
        Container   $app,
        MvscRequest $request,
    ) {
        parent::__construct($app, $request);
    }

    public function execute(): bool
    {
        try {
            $taskController = $this->buildTaskControllers($this->request);

            $this->setSubController($taskController);

            $result = parent::execute();
        } catch (Throwable $e){
            $this->request->getMsgQue()->addMessage(
                $e->getMessage(), 'errors'
            );

            return false;
        }

        return $result;
    }

    protected function buildTaskControllers(MvscRequest $request): SingleTaskController
    {
        $tasks = $request->getTaskList();

        // Build task in reverse order
        $tasks = array_reverse($tasks);

        $controller = null;
        $subController = null;

        foreach ($tasks AS $task) {
            $controllerName = 'App\Services\Mvsc\Controllers\\' . ucfirst(strtolower($task));
            if (!class_exists($controllerName)) {
                continue;
            }

            /** @var SingleTaskController $controller */
            $controller = new $controllerName(
                $this->app, $this->request);

            $controller->setSubController($subController);
            $subController = $controller;
        }

        if (!$controller instanceof SingleTaskController){
            $controller = new Get($this->app, $this->request);
        }

        return $controller;
    }


    public function getResponse(): mixed
    {
        $response = $this->getSubControllerResponse();
        $mgsQue = $this->request->getMsgQue();

        if (empty($response) && $mgsQue->has('errors'))
        {
            return view('system.error',
                [
                    'msgQue' => $mgsQue
                ]
            );
        }

        return $response;
    }
}
