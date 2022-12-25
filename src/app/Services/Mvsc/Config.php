<?php

declare(strict_types=1);

namespace App\Services\Mvsc;

use ArrayAccess;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Illuminate\Support\Facades\Config as SystemConfig;

/**
 * This is a configuration class for the single task controllers.
 * The idea is to prevent accidental mutation by storing controller configuration
 * in a unique config repository instance instead of the global system config instance.
 */
class Config implements ArrayAccess,RepositoryContract
{
    protected $systemConfig;

    public function __construct(
        ?string $view = null,
        ?string $template = null,
        ?string $resource = null,
        ?int $id = null)
    {
        $this->systemConfig = new Repository();

        $view = $view ?? $this->get('mvsc.default_view', 'index');

        $this->set('view', $view);
        $this->set('template', $template);
        $this->set('resource', $resource);
        $this->set('id', $id);

        $this->setViewTemplate($view, $template);
        $this->setResourceName($view, $resource);
    }

    protected function setViewTemplate($view, $template)
    {
        if ($view === 'index'){
            $this->set('viewTemplate', $view);
            return;
        }

        $template = empty($template) ? $view . '.default' : $view . '.' . $template;
        $this->set('viewTemplate', $template);
    }

    protected function setResourceName($view, ?string $resource = null)
    {
        if ($resource !== null){
           $this->set('resourceName', $resource);
           return;
        }

        if ($view === 'index'){
            $this->set('resourceName', $this->get('mvsc.default_resource'));
            return;
        }

        $this->set('resourceName', $view);
    }

    public function isProduction(): bool
    {
        return $this->get('app.env') === 'production';
    }


    public function get($key, $default = null): mixed
    {
        if (!$this->has($key)){
            return SystemConfig::get($key, $default);
        }

        return $this->systemConfig->get($key, $default);
    }

    public function has($key): bool
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

    public function offsetExists(mixed $offset): bool
    {
        return $this->systemConfig->offsetExists($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->systemConfig->offsetGet($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
       $this->systemConfig->offsetSet($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->systemConfig->offsetUnset($offset);
    }
}
