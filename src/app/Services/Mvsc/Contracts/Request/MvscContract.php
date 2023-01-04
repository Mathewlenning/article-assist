<?php

declare(strict_types=1);

namespace App\Services\Mvsc\Contracts\Request;

use App\Services\Mvsc\SystemNotifications\MessageQueue;
use App\Services\Mvsc\Models\MvscBase;

interface MvscContract
{
    /**
     * Task list is used by the dispatcher to determine which controllers to
     * load during this execution cycle. The default behavior can be overridden by adding
     * a task variable in the request.
     *
     * @return array
     */
    public function getTaskList(): array;

    public function getView(): string;

    public function getViewTemplate(): ?string;

    public function getIds(): array;

    public function getId(): int;

    public function getModel(string $name = ''): ?MvscBase;

    public function getMsgQue(): MessageQueue;

    public function logErrorsToQueue(array $errors);
}
