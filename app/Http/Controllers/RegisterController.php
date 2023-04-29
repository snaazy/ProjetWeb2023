<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Formation;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $formations = Formation::all();
        return view('auth.register', ['formations' => $formations]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:40',
            'prenom' => 'required|string|max:40',
            'login' => 'required|string|max:30|unique:users',
            'mdp' => 'required|string|min:5',
            'formation_id' => 'nullable|exists:formations,id'
        ]);

        // Récupération du type d'utilisateur
        $type = $request->input('type');
        // Si l'utilisateur est un admin, on ne l'assigne pas à une formation
        if ($type == 'admin') {
            $formation_id = null;
        } elseif ($type == 'enseignant') {
            // Si l'utilisateur est un enseignant, on ne l'assigne pas à une formation et on met son type à 'enseignant'
            $formation_id = null;
            $type = 'enseignant';
        } else {    
            // Sinon, on l'assigne à la formation choisie
            $formation_id = $request->input('formation_id');
        }
        // Création d'un nouvel utilisateur avec les données du formulaire
        User::create([
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'login' => $request->input('login'),
            'mdp' => bcrypt($request->input('mdp')),
            'formation_id' => $formation_id,
            'type' => $type
        ]);
        // Redirection avec un message de succès en fonction du type d'utilisateur créé
        if ($type == 'admin') {
            return redirect('/login')->with('success', 'Compte administrateur créé avec succès.');
        } elseif ($type == 'enseignant') {
            return redirect('/login')->with('success', 'Compte enseignant créé avec succès.');
        } else {
            return redirect('/login')->with('success', 'Votre compte a été créé avec succès. Veuillez attendre que l\'administrateur valide votre compte.');
        }
    }
    
    
    
    
    
    
}
