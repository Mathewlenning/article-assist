<?php

namespace App\Services\Mvsc\Controllers;

use App\Services\Mvsc\Models\MvscBase;
use App\Services\Mvsc\Requests\MvscRequest;
use Illuminate\Support\Facades\View as ViewFactory;
use Illuminate\View\View;

/**
 * Handles input validation
 */
class Register extends Controller
{
    protected ?View $view = null;

    public function execute(): bool
    {
        $model = $this->getModel('User');
        $request = $this->request;

        /**
         * Get the model
         * validate the input data
         * render the view with validation error data
         * or return true
         */
        return parent::execute();
    }

    public function getResponse(): mixed
    {
        return $this->view;
    }
}
