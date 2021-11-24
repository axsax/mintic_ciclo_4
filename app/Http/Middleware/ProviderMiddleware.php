<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Closure;

class providerMiddleware extends ApiController
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->role == User::provider_role) {
            return $next($request);
        }
        $request->user()->token()->revoke();
        return $this->errorResponse("Unauthorized", 401);
    }
}
