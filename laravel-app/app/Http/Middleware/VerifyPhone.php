<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\HttpResponses;

class VerifyPhone
{
    use HttpResponses;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next, $redirectToRoute = null): Response
    {
        if (! $request->user() || (! $request->user()->hasVerifiedPhone())) 
        {
            return $this->error('Phone not verified','Unauthorized', 401);
        }

        return $next($request);
    }
}
