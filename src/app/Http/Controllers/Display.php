<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as ViewFactory;
use Illuminate\View\View;

class Display extends Controller
{
    protected ?View $view = null;

    public function execute(Request $request): bool
    {
        $viewData = [
        'model' => $this->getResourceModel($request, $this->config->get('resource')),
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
        $view = $request->input('view', $this->config->get('view', 'index'));

        if($view !== 'index' && strpos($view, '.') === false)
        {
            $view .= '.index';
        }

        return strtolower($view);
    }


    public function getResponse(): mixed
    {
        return $this->view;
    }
}
