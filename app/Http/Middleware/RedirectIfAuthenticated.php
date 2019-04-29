<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = $request->user(); 
        
        if((Auth::guard($guard)->check()) && ($user->statut == "admin")) {
            return redirect('/admin/dashboard');
        } else if((Auth::guard($guard)->check()) && ($user->statut == "gerant")) {
            return redirect('/gerant/dashboard');
        }

        return $next($request);
    }
}
