<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HttpsProtocolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->secure() && app()->environment('production')) {
            $arr = explode('/', $request->getRequestUri());
            array_shift($arr);
            array_shift($arr);
            $url = implode('/', $arr);
            ddd($url);
            return redirect()->secure($url);
        }

        // if (!$request->secure() && app()->environment('production')) {
        //     return redirect(env('APP_URL') . $request->path());
        // }

        return $next($request);
    }
}
