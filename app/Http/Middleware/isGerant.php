<?php

namespace App\Http\Middleware;

use Closure;

class isGerant
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
        
        $user = $request->user();
        if($user && $user->statut != "gerant") {
            return redirect('admin/');
        }
        return $next($request);
    }
}
