<?php

namespace App\Services\Mvsc\Requests;

use App\Services\Mvsc\Models\MvscBase;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request AS BaseRequest;
use Illuminate\Support\Facades\Config;
use RuntimeException;

class Request extends BaseRequest
{
    protected ?string $view = null;
    protected ?string $view_template = null;
    protected array    $ids = [];
    protected ?MvscBase $model = null;

    public function setView(?string $view = null): static
    {
        $this->view = $view ?? Config::get('mvsc.default_view', 'index');

        return $this;
    }

    public function getView()
    {
        return $this->input('view', $this->view);
    }

    public function setViewTemplate(?string $template = null): static
    {
        $view = $this->view;

        if ($view === 'index'){
            $this->view_template = $view;
            return $this;
        }

        $this->view_template = empty($template)
            ? $view . '.default'
            : $view . '.' . $template;

        return $this;
    }

    public function getViewTemplate(): ?string
    {
        return $this->input('view_template', $this->view_template);
    }

    public function setIds(int $id = null): static
    {
        $this->ids = $this->input('ids', [$id]);

        return $this;
    }

    public function getIds(): array
    {
        return $this->ids;
    }

    public function getId(): int
    {
        return $this->ids[0] ?? 0;
    }


    public function setModel(?string $modelName = null): static
    {
        if (empty($modelName) || $modelName === 'index')
        {
            $this->model = $this->getModel(Config::get('mvsc.default_model'));
            return $this;
        }

        $this->model = $this->getModel($modelName);
        return $this;
    }

    public function getModel(string $name = ''): ?Model
    {
        if (empty($name) || $name === 'index'){
            $name = Config::get('mvsc.default_model');
        }

        $modelFullName = 'App\Models\\'.ucfirst($name);
        if (!class_exists($modelFullName)) {
            return null;
        }

        return new $modelFullName();
    }

    /**
     * Task list is used by the dispatcher to determine which controllers to
     * load during this execution cycle. The default behavior can be overridden by adding
     * a task variable in the request.
     *
     * @return array
     */
    public function getTaskList(): array
    {
        $requestTasks = $this->input('tasks',[$this->method()]);

        if(!is_array($requestTasks)){
            $requestTasks = [$requestTasks];
        }

        // Ajax controller is only allowed for ajax requests.
        $preparedTasks = array_filter(
            $requestTasks,
            fn($value) => $value !== 'Ajax'
        );

        if ($this->ajax()){
            array_unshift($preparedTasks, 'Ajax');
        }

        return $preparedTasks;
    }
}
