<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //get locale from request
        $locale = $request->header('Locale');

        //set locale
        if($locale && in_array($locale, ['en', 'ua', 'ru']))
            App::setLocale($locale);

        return $next($request);
    }
}
