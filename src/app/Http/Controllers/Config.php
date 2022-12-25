<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use ArrayAccess;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Illuminate\Support\Facades\Config as SystemConfig;

/**
 * This is a configuration class for the single task controllers.
 * The idea is to prevent accidental mutation by storing $resource and $id
 * in a unique config repository instance instead of the global system config.
 */
class Config implements ArrayAccess,RepositoryContract
{
    protected $systemConfig;

    public function __construct(
        ?string $view = null,
        ?int $id = null)
    {
        $this->systemConfig = new Repository(SystemConfig::all());
        if ($view === null) {
            $view = $this->systemConfig->get('app.default_view', 'index');
        }

        $this->systemConfig->set('view', $view);
        $this->systemConfig->set('id', $id);
    }

    public function get($key, $default = null): mixed
    {
        return $this->systemConfig->get($key, $default);
    }

    public function has($key)
    {
        return $this->systemConfig->has($key);
    }

    public function all(): array
    {
        return $this->systemConfig->all();
    }

    public function set($key, $value = null)
    {
        $this->systemConfig->set($key, $value);
    }

    public function prepend($key, $value)
    {
        $this->systemConfig->prepend($key, $value);
    }

    public function push($key, $value)
    {
        $this->systemConfig->push($key, $value);
    }

    public function getSystemConfig(): Repository
    {
        return $this->systemConfig;
    }

    public function offsetExists(mixed $key): bool
    {
        return $this->systemConfig->offsetExists($key);
    }

    public function offsetGet(mixed $key): mixed
    {
        return $this->systemConfig->offsetGet($key);
    }

    public function offsetSet(mixed $key, mixed $value): void
    {
       $this->systemConfig->offsetSet($key, $value);
    }

    public function offsetUnset(mixed $key): void
    {
        $this->systemConfig->offsetUnset($key);
    }
}
