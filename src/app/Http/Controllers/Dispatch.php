<?php

namespace App\Http\Controllers;

use App\Interfaces\SingleTaskController;

use App\Interfaces\SystemNotifications;
use Illuminate\Container\Container;
use Illuminate\Http\Request;

class Dispatch extends Controller
{
    public function __construct(
        Container $app,
        SystemNotifications $msgQue,
        Config $config)
    {
        parent::__construct($app, $msgQue, $config);
    }

    public function execute(Request $request): bool
    {
        try {

            $this->setSubController($this->buildTaskControllers($request));
            $this->executeSubController($request);
        } catch (\Throwable $e){
            $this->msgQue->addMessage($e->getMessage(), 'errors');
            return false;
        }

        return true;
    }

    protected function buildTaskControllers(Request $request): SingleTaskController
    {
        $tasks = $this->getTaskList($request);
        $resources = $request->input('resources', [$this->config->get('view')]);
        $ids = $request->input('ids', [$this->config->get('id')]);

        // Build task in reverse order
        $tasks = array_reverse($tasks);
        $resources = array_reverse($resources);
        $ids = array_reverse($ids);

        $resource = $resources[0];
        $id = $ids[0];
        $controller = null;
        $subController = null;


        foreach ($tasks AS $index => $task) {
            $controllerName = 'App\Http\Controllers\\' . $task;
            if (!class_exists($controllerName)) {
                continue;
            }

            if (isset($resources[$index])) {
                $resource = $resources[$index];
            }

            if (isset($ids[$index])) {
                $id = $ids[$index];
            }

            $config = new Config($resource, $id);
            /** @var SingleTaskController $controller */
            $controller = new $controllerName($this->app, $this->msgQue, $config);

            $controller->setSubController($subController);
            $subController = $controller;
        }

        if (!$controller instanceof SingleTaskController){
            $controller = new Display($this->app, $this->msgQue, $this->config);
        }

        return $controller;
    }

    protected function getTaskList(Request $request): array
    {
        // Ajax controller is only allowed for ajax requests.
        $tasks = array_filter(
            $request->input('tasks', ['Display']),
            fn($value) => $value !== 'Ajax');

        if ($request->ajax()){
            array_unshift($tasks, 'Ajax');
        }

        return $tasks;
    }

    public function getResponse(): mixed
    {
        $response = $this->getSubControllerResponse();

        if (empty($response) && $this->msgQue->has('errors'))
        {
            return view('system.error',
                [
                    'config' => $this->config,
                    'msgQue' => $this->msgQue
                ]
            );
        }

        return $response;
    }
}
