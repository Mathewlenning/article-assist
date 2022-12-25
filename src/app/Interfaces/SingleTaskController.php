<?php

declare(strict_types=1);

namespace App\Interfaces;

use Illuminate\Http\Request;

interface SingleTaskController
{
    public function execute(Request $request): bool;

    public function getResponse(): mixed;

    /** @return $this */
    public function setSubController(?SingleTaskController $controller = null): static;
}
