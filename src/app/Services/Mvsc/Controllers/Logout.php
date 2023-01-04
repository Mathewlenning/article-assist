<?php

declare(strict_types=1);

namespace App\Services\Mvsc\Controllers;

use Illuminate\Support\Facades\Auth;

class Logout extends Controller
{
    public function execute(): bool
    {
        Auth::logout();
        $request = $this->request;

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return parent::execute();
    }
}
