<?php

namespace App\Services\Mvsc\Controllers;

use Illuminate\View\View;

/**
 * Handles input validation
 */
class Validate extends Controller
{
    protected ?View $view = null;

    public function execute(): bool
    {
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
