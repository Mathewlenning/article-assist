<?php

namespace App\Services\Mvsc\Requests;

use App\Services\Mvsc\Contracts\Request\MvscContract;
use App\Services\Mvsc\Models\MvscBase;
use App\Services\Mvsc\SystemNotifications\MessageQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator as ValidatorFactory;
use Illuminate\Validation\Validator;
use RuntimeException;

class MvscRequest implements MvscContract
{
    public function __construct(
        public Request $request,
        protected MessageQueue $msgQue,
        protected ?string $view = 'index',
        protected ?string $template = null,
        protected int|null $id = null
    ) {
    }

    public function getView(): string
    {
        return $this->request->input('view', $this->view);
    }

    public function getViewTemplate(): ?string
    {
        $view = $this->view;

        if (!empty($this->template)) {
            return $this->request->input('view_template', $view . '.' .$this->template);
        }

        return $this->request->input('view_template', $view . '.default');
    }

    public function getIds(): array
    {
        if (!is_int($this->id)){
            return $this->request->input('ids', []);
        }

        return $this->request->input('ids', [$this->id]);
    }

    public function getId(): int
    {
        return $this->getIds()[0] ?? 0;
    }

    public function getMsgQue(): MessageQueue {
        return $this->msgQue;
    }

    public function logErrorsToQueue(array $errors)
    {
        foreach ($errors AS $errorGroup)
        {
            foreach ($errorGroup AS $msg)
            {
                $this->msgQue->addMessage($msg, 'errors');
            }
        }
    }

    public function getModel(string $name = ''): ?MvscBase
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

    public function getRequestValidator(MvscBase $model): Validator
    {
        return ValidatorFactory::make(
            $this->request->all()[$model->getFormInputName()],
            $model->getFormValidationRules()
        );
    }

    public function validateRequest(MvscBase $model): array
    {
        $validator = $this->getRequestValidator($model);

        if ($validator->fails())
        {
            $this->logErrorsToQueue($validator->errors()->toArray());
            throw new RuntimeException(code:422);
        }

        return $validator->safe()->all();
    }

    public function getTaskList(): array
    {
        $requestTasks = $this->request->input('tasks',[$this->request->method()]);

        if(!is_array($requestTasks)){
            $requestTasks = [$requestTasks];
        }

        // Ajax controller is only allowed for ajax requests.
        $preparedTasks = array_filter(
            $requestTasks,
            fn($value) => $value !== 'Ajax'
        );

        if ($this->request->ajax()){
            array_unshift($preparedTasks, 'Ajax');
        }

        return $preparedTasks;
    }

    public function input($key = null, $default = null): mixed
    {
        return $this->request->input($key, $default);
    }

    public function url(): string
    {
        return $this->request->url();
    }
}
