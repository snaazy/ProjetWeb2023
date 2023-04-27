<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
    
        $user = User::where('login', $request->input('login'))->first();
        if ($user) {
            if ($user->type === NULL) {
                return back()->withErrors([
                    'login' => 'Votre inscription a été refusée ou bien mise en attente.',
                ]);
            }
            
            // Le reste du code de la méthode login
        }
        
        if ($user) {
            \Log::debug('Found user with login: ' . $request->input('login'));
            \Log::debug('Stored password hash: ' . $user->mdp);
    
            if (Hash::check($request->input('mdp'), $user->mdp)) {
                // Authentifiez l'utilisateur manuellement
                Auth::login($user);
                
                $request->session()->regenerate();
    
                $request->session()->flash('etat', 'Login successful');
    
                if ($user->isAdmin()) {
                    return redirect()->route('admin.home');
                } else {
                    return redirect('/');
                }
            } else {
                \Log::debug('Hash::check failed for login: ' . $request->input('login'));
            }
        } else {
            \Log::debug('No user found with login: ' . $request->input('login'));
        }
    
        return back()->withErrors([
            'login' => 'Ces identifiants ne correspondent pas à nos enregistrements.',
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
