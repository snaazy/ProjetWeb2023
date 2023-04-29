<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Hash;


use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    /**
     * Vérifie si l'utilisateur est administrateur.
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * Affiche le profil de l'utilisateur.
     */
    public function profil()
    { // Récupérer l'utilisateur connecté
        $user = Auth::user();
        // Récupérer l'intitulé de la formation de l'utilisateur, s'il en a une
        $formation = optional($user->formation)->intitule ?? "non-étudiant";
        // Renvoyer la vue du profil de l'utilisateur en passant les données récupérées précédemment
        return view('user.profile', compact('user', 'formation'));
    }



    public function destroy(User $user)
    {
        try {
            // Supprime l'utilisateur
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'L\'utilisateur a été supprimé avec succès.');
        } catch (\Illuminate\Database\QueryException $e) {
            // On recupère le code d'erreur en cas d'exception lors de la suppression de l'utilisateur
            $errorCode = $e->errorInfo[1];
            // Si l'erreur est une violation de clé étrangère alors des données sont liées à cet utilisateur, on ne peut donc pas le supprimer
            if ($errorCode == 1451) {
                return redirect()->route('admin.users.index')->with('error', 'Impossible de supprimer l\'utilisateur car des données y sont liées. Veuillez vous assurer que toutes les données liées à cet utilisateur, comme les notes et les absences associées, ont été supprimées avant de procéder à la suppression de l\'utilisateur.');
            } else {
                // Sinon, une erreur inconnue est survenue, on redirige donc vers la page d'index des utilisateurs avec un message d'avertissement
                return redirect()->route('admin.users.index')->with('warning', 'Une erreur est survenue lors de la suppression de l\'utilisateur. Veuillez respecter les conditions avant de supprimer un utilisateur.');
            }
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
        ]);
        // Mise à jour des informations de l'utilisateur
        $user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
        ]);

        return redirect()->route('profil')->with('success', 'Les informations ont été mises à jour avec succès.');
    }

    public function show()
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur est un étudiant ou un enseignant et récupérer les cours correspondants
        if ($user->type == 'etudiant') {
            $courses = $user->courses;
        } else {
            $courses = $user->assignedCourses;
        }

        return view('profil', [
            'user' => $user,
            'courses' => $courses,
        ]);
    }


    public function showChangePasswordForm()
    {
        return view('user.changepassword');
    }

    public function changePassword(Request $request)
    {

        $user = auth()->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:2',
            'new_password_confirmation' => 'required|same:new_password',
        ]);
        // Vérification de la correspondance du mot de passe actuel avec celui de l'utilisateur
        if (!Hash::check($request->input('current_password'), $user->mdp)) {
            return redirect()->back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }
        // Mise à jour du mot de passe de l'utilisateur
        $user->mdp = bcrypt($request->input('new_password'));
        $user->save();

        return redirect()->route('profil')->with('success', 'Le mot de passe a été modifié avec succès.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:40',
            'prenom' => 'required|string|max:40',
            'login' => 'required|string|max:30|unique:users',
            'mdp' => 'required|string|min:1',
            'formation_id' => 'nullable|exists:formations,id',
            'type' => 'required|in:etudiant,enseignant,admin',
        ]);

        // Création d'un nouvel utilisateur avec les données du formulaire
        User::create([
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'login' => $request->input('login'),
            'mdp' => bcrypt($request->input('mdp')),
            'formation_id' => $request->input('formation_id'),
            'type' => $request->input('type')
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé avec succès.');
    }




}