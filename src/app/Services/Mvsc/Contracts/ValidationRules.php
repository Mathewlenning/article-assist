<?php

declare(strict_types=1);

namespace App\Services\Mvsc\Contracts;

/**
 *
 */
interface ValidationRules
{
    static public function getFormValidationRules(?array $additionalRules = []): array;
}
