<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() != null) {
            $actions = $request->route()->getAction();
            if (isset($actions['role'])) {
                foreach($actions['role'] as $role)
                if ($request->user()->hasRole($role) || !$role)
                    return $next($request);
            }
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
