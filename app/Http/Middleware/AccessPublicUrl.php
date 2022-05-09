<?php

namespace App\Http\Middleware;

use App\SettingRoute;
use Illuminate\Http\Request;
use Closure;
class AccessPublicUrl
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeAccess = SettingRoute::where('route_path', $request->route()->uri)->where('route_status', 1)->first();
        if (!$routeAccess ) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
