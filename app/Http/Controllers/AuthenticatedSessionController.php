<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Contrôleur pour gérer les sessions authentifiées.
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * Afficher le formulaire de connexion.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Authentifier et connecter un utilisateur.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'mdp' => 'required|string'
        ]);

        $credentials = ['login' => $request->input('login'), 'password' => $request->input('mdp')];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->flash('etat', 'Login successful');

            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.home');
            } else {
                return redirect('/main');
            }
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ]);
    }


    /**
     * Déconnecter un utilisateur et invalider sa session.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
