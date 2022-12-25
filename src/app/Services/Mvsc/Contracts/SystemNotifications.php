<?php

declare(strict_types=1);

namespace App\Services\Mvsc\Contracts;

interface SystemNotifications
{
    /**
     * @param   string  $msg      The message
     * @param   string  $msgType  The type of message e.g. ('message', 'warning', 'error')
     * @return $this
     */
    public function addMessage(string $msg, string $msgType = 'message') : static;

    /**
     * @param ?string  $msgType  The type of message e.g. ('message', 'warning', 'error')
     * @return array
     */
    public function getMessages(?string $msgType = ''): array;

    /**
     * @param   ?string  $msgType  The type of message e.g. ('message', 'warning', 'error')
     * @return $this
     */
    public function clearMessages(?string $msgType = ''): static;

    /**
     * @param   ?string  $msgType  The type of message e.g. ('message', 'warning', 'error')
     * @return bool
     */
    public function has(?string $msgType = null): bool;
}
