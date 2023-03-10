<?php

namespace App\Services\Mvsc\Controllers;

use App\Services\Mvsc\Requests\MvscRequest;
use Illuminate\Support\Facades\View as ViewFactory;
use Illuminate\View\View;

/**
 * Handles CRUD Read operations
 */
class Get extends Controller
{
    protected ?View $view = null;

    public function execute(): bool
    {
        $viewData = [
            'model' => $this->getModel(id: $this->request->getId()),
            'request' => $this->request,
            'msgQue' => $this->request->getMsgQue()
        ];

        $this->view = ViewFactory::make(
            $this->request->getViewTemplate(),
            $viewData
        );

        return parent::execute();
    }

    public function getResponse(): mixed
    {
        return $this->view;
    }
}
