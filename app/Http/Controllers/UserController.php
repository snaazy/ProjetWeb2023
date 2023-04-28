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
    {
        $user = Auth::user();
        $formation = optional($user->formation)->intitule ?? "non-étudiant";
        return view('user.profile', compact('user', 'formation'));
    }



    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'L\'utilisateur a été supprimé avec succès.');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return redirect()->route('admin.users.index')->with('error', 'Impossible de supprimer l\'utilisateur car des données y sont liées. Veuillez vous assurer que toutes les données liées à cet utilisateur, comme les notes et les absences associées, ont été supprimées avant de procéder à la suppression de l\'utilisateur.');
            } else {
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

        $user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
        ]);

        return redirect()->route('profil')->with('success', 'Les informations ont été mises à jour avec succès.');
    }

    public function show()
    {
        $user = Auth::user();

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

        if (!Hash::check($request->input('current_password'), $user->mdp)) {
            return redirect()->back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->mdp = bcrypt($request->input('new_password'));
        $user->save();

        return redirect()->route('profil')->with('etat', 'Le mot de passe a été modifié avec succès.');
    }



}