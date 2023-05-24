<?php

namespace App\Http\Middleware;

use Closure;
use App\helpers\helper;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDeliType
{

    public function __construct()
    {
        $this->helper = new helper();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth('sanctum')->user()->userType  == 'delivery'){
            return $next($request);

        }
        return $this->helper->ResponseJson(0,'rou are not authorized' , []);

    }
}
