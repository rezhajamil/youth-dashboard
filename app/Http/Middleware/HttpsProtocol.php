<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HttpsProtocol
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle($request, Closure $next)
    // {
    //     // Set trusted proxies with IP addresses and trust level
    //     $request->setTrustedProxies([$request->getClientIp()], Request::HEADER_X_FORWARDED_ALL);

    //     if (!$request->isSecure()) {
    //         // Redirect non-secure requests to HTTPS
    //         return redirect()->secure($request->getRequestUri());
    //     }

    //     return $next($request);
    // }
}
