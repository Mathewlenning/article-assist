<?php

namespace App\Services\Mvsc\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as ViewFactory;
use Illuminate\View\View;

class Display extends Controller
{
    protected ?View $view = null;

    public function execute(Request $request): bool
    {
        $viewData = [
        'model' => $this->getResourceModel($this->config->get('resource')),
        'request' => $request,
        'config' => $this->config,
        'msgQue' => $this->msgQue
        ];

        $this->view = ViewFactory::make(
            $this->getResourceView($request),
            $viewData
        );

        return true;
    }


    protected function getResourceView(Request $request): string
    {
        return strtolower($request->input('viewTemplate', $this->config->get('viewTemplate', 'index')));
    }


    public function getResponse(): mixed
    {
        return $this->view;
    }
}
