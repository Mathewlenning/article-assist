<?php

namespace App\Services\Mvsc\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\View as ViewFactory;
use Illuminate\Contracts\View\View;

class Ajax extends Controller
{
    protected ?string $location = null;

    public function getResponse(): mixed
    {
        $response = [
            'notifications' => $this->getNotifications(),
            'body' => $this->getResponseBody(),
            'location' => $this->location ?? $this->request->url()
        ];

        return new JsonResponse($response);
    }

    protected function getNotifications(): array
    {
        return [
            'raw' => $this->request->getMsgQue()->getMessages(),
            'formatted' => $this->getFormattedMessages()
        ];
    }

    protected function getFormattedMessages(): string
    {
        return ViewFactory::make('system.notifications', ['msgQue' => $this->request->getMsgQue()])->render();
    }

    protected function getResponseBody(): mixed
    {
        $response = $this->getSubControllerResponse();

        if ($response instanceof View)
        {
            $response = $response->render();
        }

        if ($response instanceof RedirectResponse)
        {
            $this->location = $response->getTargetUrl();
            return null;
        }

        return $response;
    }
}
