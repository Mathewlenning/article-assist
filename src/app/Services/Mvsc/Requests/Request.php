<?php

namespace App\Services\Mvsc\Requests;

use App\Services\Mvsc\Models\MvscBase;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use RuntimeException;

class Request extends FormRequest
{
    protected ?string $view = null;
    protected ?string $view_template = null;
    protected array    $ids = [];
    protected ?MvscBase $model = null;

    public function setView(?string $view = null): static
    {
        $this->view = $view
            ?? Config::get(
                'mvsc.default_view',
                'index'
            );

        return $this;
    }

    public function getView()
    {
        return $this->input(
            'view',
            $this->view);
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
        return $this->input(
            'view_template',
            $this->view_template);
    }

    public function setIds(int $id = null): static
    {
        $this->ids = $this->input('ids', [$id]);

        return $this;
    }

    public function setModel(?string $modelName = null): static
    {
        if (empty($modelName) || $modelName === 'index')
        {
            $this->model = $this->getModel(Config::get('mvsc.default_model'));
          ;
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

    public function getTaskList(): array
    {
        // Ajax controller is only allowed for ajax requests.
        $tasks = array_filter(
            $this->input('tasks',[$this->method()]),
            fn($value) => $value !== 'Ajax');

        if ($this->ajax()){
            array_unshift($tasks, 'Ajax');
        }

        return $tasks;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }

    public function setRules($rules = []): static
    {
        $this->validator->setRules($rules);
        return $this;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new RuntimeException('Validation Failed', 422);
    }
}
