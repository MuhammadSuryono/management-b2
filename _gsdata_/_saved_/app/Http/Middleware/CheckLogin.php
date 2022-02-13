<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
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
        if (session('logged_in') <> true OR time() - session('LAST_ACTIVITY') > 1000 ) {
            return redirect()->route('login');
        }
        session(['LAST_ACTIVITY'=>time()]);
        return $next($request);
    }
}
