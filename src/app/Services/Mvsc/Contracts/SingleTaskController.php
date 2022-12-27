<?php

declare(strict_types=1);

namespace App\Services\Mvsc\Contracts;

use App\Services\Mvsc\Requests\Request;

interface SingleTaskController
{
    public function execute(): bool;

    public function getResponse(): mixed;

    /** @return $this */
    public function setSubController(?SingleTaskController $controller = null): static;
}
