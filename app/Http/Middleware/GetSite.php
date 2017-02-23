<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class GetSite
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
        App::singleton('site', function() use ($request) {

            $class = config('fabric.site');

            try
            {
                return $class::where('id', session('site_id'))->firstOrFail();

            } catch(\Exception $e)
            {
                return null;
            }
        });

        return $next($request);
    }
}
