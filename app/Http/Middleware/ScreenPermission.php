<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Models\Security;

class ScreenPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $screenId = null, $studentEntityId = null)
    {
        $security = new Security($screenId, $studentEntityId);

        if (! $security->hasScreenPermission()) {
            return response("Unauthorized. You don't have permission to access this screen.", 401);
        }

        return $next($request);
    }
}
