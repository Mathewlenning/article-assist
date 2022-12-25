<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http;

class XssSanitizer
{
    /**
     * Strips tags from input values
     *
     * @param Http\Request                                                        $request
     * @param Closure(Http\Request): (Http\Response|Http\RedirectResponse) $next
     * @return Http\Response|Http\RedirectResponse
     */
    public function handle(Http\Request $request, Closure $next)
    {
        $input = $request->all();

        array_walk_recursive($input, function(&$input) {
            $input = strip_tags($input);
        });

        $request->merge($input);
        return $next($request);
    }
}
