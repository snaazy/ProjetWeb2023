<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
    
        if (auth()->check() && ($user->type === null)) {
            auth()->logout();
            return redirect('/login')->with('error', 'Votre compte est en attente d\'approbation par un administrateur.');
        }
    
        return $next($request);
    }
    
    
}
