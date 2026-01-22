<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        abort_if(!$user || !$user->is_admin, 403);

        return $next($request);
    }
}
