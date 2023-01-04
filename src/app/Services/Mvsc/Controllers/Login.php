<?php

declare(strict_types=1);

namespace App\Services\Mvsc\Controllers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    protected bool $authResult;
    public function execute(): bool
    {
        $request = $this->request;
        $credentials = $this->request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $this->authResult = Auth::attempt($credentials);

        if ($this->authResult) {
            $request->session()->regenerate();

            return parent::execute();
        }

        throw new AuthenticationException('Login Failed');
    }

    public function getResponse(): mixed
    {
        if ($this->authResult)
        {
            return parent::getResponse();
        }

        return back()->withInput();
    }
}
