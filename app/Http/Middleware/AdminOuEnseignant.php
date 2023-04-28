<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOuEnseignant
{

    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->type === 'enseignant' || auth()->user()->type === 'admin') {
            return $next($request);
        }

        return redirect('/')->withErrors(['Vous n\'avez pas l\'autorisation d\'accéder à cette page.']);
    }
}