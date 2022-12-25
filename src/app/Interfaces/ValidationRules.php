<?php

declare(strict_types=1);

namespace App\Interfaces;

interface ValidationRules
{
    static public function getFormValidationRules(?array $additionalRules = []): array;
}
