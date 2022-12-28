<?php

namespace App\Services\Mvsc\Controllers;

use App\Services\Mvsc\Requests\Request;
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
            'msgQue' => $this->msgQue
        ];

        $this->view = ViewFactory::make(
            $this->request->getViewTemplate(),
            $viewData
        );

        return true;
    }

    public function getResponse(): mixed
    {
        return $this->view;
    }
}
