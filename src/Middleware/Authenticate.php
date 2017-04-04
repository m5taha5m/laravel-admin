<?php

namespace Encore\Admin\Middleware;

use Closure;
use Encore\Admin\Admin;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->guest() && !$this->shouldPassThrough($request)) {
            return redirect()->route(config('admin.route-group-name').'.login');
        }

        return $next($request);
    }

    /**
     * Determine if the request has a URI that should pass through verification.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function shouldPassThrough($request)
    {
        $excepts = [
            Route(config('admin.route-group-name').'.login'),
            Route(config('admin.route-group-name').'.logout')
        ];

        foreach ($excepts as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except)) {
                return true;
            }
        }

        return false;
    }
}
