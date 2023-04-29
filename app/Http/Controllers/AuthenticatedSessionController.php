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
        // Valide les données de la requête
        $request->validate([
            'login' => 'required|string',
            'mdp' => 'required|string'
        ]);
        
        // Prépare les identifiants pour vérifier l'authentification
        $credentials = ['login' => $request->input('login'), 'password' => $request->input('mdp')];

        // Recherche l'utilisateur correspondant au login fourni
        $user = User::where('login', $request->input('login'))->first();
        if ($user) {
            // Vérifie si le type d'utilisateur est null (inscription refusée ou en attente)
            if ($user->type === NULL) {
                return back()->withErrors([
                    'login' => 'Votre inscription a été refusée ou bien mise en attente.',
                ]);
            }
        }
        
        if ($user) {
            // Enregistre dans les logs qu'un utilisateur correspondant au login a été trouvé
            \Log::debug('Found user with login: ' . $request->input('login'));
            \Log::debug('Stored password hash: ' . $user->mdp);
            // Vérifie si le mot de passe fourni correspond au mot de passe hashé stocké
            if (Hash::check($request->input('mdp'), $user->mdp)) {
                // Authentifiez l'utilisateur manuellement
                Auth::login($user);
                // Régénère la session pour éviter les attaques de fixation de session
                $request->session()->regenerate();
                // Ajoute un message flash pour indiquer que la connexion a réussi
                $request->session()->flash('etat', 'Login successful');
                // Redirige l'utilisateur vers la page d'accueil en fonction de son type
                if ($user->isAdmin()) {
                    return redirect()->route('admin.home');
                } else {
                    return redirect('/');
                }
            } else {
                // Enregistre dans les logs que la vérification du mot de passe a échoué
                \Log::debug('Hash::check failed for login: ' . $request->input('login'));
            }
        } else {
            // Enregistre dans les logs qu'aucun utilisateur correspondant au login n'a été trouvé
            \Log::debug('No user found with login: ' . $request->input('login'));
        }
        // Si la connexion échoue, renvoie l'utilisateur à la page précédente avec un message d'erreur
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
        // Déconnecte l'utilisateur actuellement authentifié
        Auth::logout();
        // Invalide les données de la session en cours
        $request->session()->invalidate();
        // Régénère le jeton de la session pour éviter les attaques de fixation de session
        $request->session()->regenerateToken();
        // Redirige l'utilisateur vers la page d'accueil
        return redirect('/');
    }
}
