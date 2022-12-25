<?php

declare(strict_types=1);

namespace App\Services\SystemNotifications;

use App\Interfaces\SystemNotifications;

class MessageQueue implements SystemNotifications
{
    private array $queue = [];

    /**
     * Messages are stored by msgType
     * @param   string  $msg      The message
     * @param   string  $msgType  The type of message e.g. ('message', 'warning', 'error')
     * @return $this
     */
    public function addMessage(string $msg, string $msgType = 'messages'): static
    {
        if (!array_key_exists($msgType,$this->queue)) {
           $this->queue[$msgType] = [];
        }

        $this->queue[$msgType][] = $msg;

        return $this;
    }

    /**
     * If $msgType is empty, the whole queue returned
     * @param ?string  $msgType  The type of message e.g. ('message', 'warning', 'error')
     * @return array
     */
    public function getMessages(?string $msgType = ''): array
    {
        if (empty($msgType)) {
            return $this->queue;
        }

        return array_key_exists($msgType, $this->queue)
            ? $this->queue[$msgType]
            : [];
    }

    /**
     * If $msgType is empty it clears all messages.
     * @param   ?string  $msgType  The type of message e.g. ('message', 'warning', 'error')
     * @return $this
     */
    public function clearMessages(?string $msgType = ''): static
    {
        if (array_key_exists($msgType, $this->queue)) {
            $this->queue[$msgType] = [];

            return $this;
        }

        $newQueue = [];
        foreach ($this->queue AS $key => $value) {
            $newQueue[$key] = [];
        }

        $this->queue = $newQueue;

        return $this;
    }

    /**
     * If $msgType is empty it checks if any messages exist.
     * @param   ?string  $msgType  The type of message e.g. ('message', 'warning', 'error')
     * @return bool
     */
    public function has(?string $msgType = null): bool
    {
        if ($msgType === null) {
            return $this->hasAny();
        }

        if (!array_key_exists($msgType, $this->queue)) {
            return false;
        }

        return count($this->queue[$msgType]) > 0;
    }

    protected function hasAny(): bool
    {
        foreach ($this->queue AS $values)
        {
            if (count($values) === 0)
            {
                continue;
            }

            return true;
        }

        return false;
    }
}
