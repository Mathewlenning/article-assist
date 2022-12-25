<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as ViewFactory;
use Illuminate\Contracts\View\View;

class Ajax extends Controller
{
    protected ?Request $request = null;

    public function execute(Request $request): bool
    {
        $this->request = $request;
        return parent::execute($request);
    }

    public function getResponse(): mixed
    {
        $response = [
            'notifications' => $this->getNotifications(),
            'body' => $this->getResponseBody(),
            'location' => $this->request->url()
        ];

        return new JsonResponse($response);
    }

    protected function getNotifications(): array
    {
        return [
            'raw' => $this->msgQue->getMessages(),
            'formatted' => $this->getFormattedMessages()
        ];
    }

    protected function getFormattedMessages(): string
    {
        return ViewFactory::make('system.notifications', ['config' => $this->config, 'msgQue' => $this->msgQue])->render();
    }

    protected function getResponseBody(): mixed
    {
        $response = $this->getSubControllerResponse();

        if ($response instanceof View)
        {

            $response = $response->render();
        }

        return $response;
    }
}
