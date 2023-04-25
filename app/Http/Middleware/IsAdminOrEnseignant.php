<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminOrEnseignant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->type === 'enseignant' || auth()->user()->type === 'admin') {
            return $next($request);
        }
    
        return redirect('/')->withErrors(['Vous n\'avez pas l\'autorisation d\'accéder à cette page.']);
    }
    
}
