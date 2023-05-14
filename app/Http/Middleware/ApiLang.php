<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class ApiLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = defaultLang();
        if ($request->header('Lang') != null && in_array($request->header('Lang'), languages())) {
          $lang = $request->header('Lang');
        } elseif (auth()->check()) {
          $lang ='en';
        }
    
        App::setLocale($lang);
        Carbon::setLocale($lang);
        return $next($request);
    }
}
