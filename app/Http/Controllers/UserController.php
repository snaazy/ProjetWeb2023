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
    $user->delete();
    return redirect()->route('admin.users.index')->with('success', 'L\'utilisateur a été supprimé avec succès.');
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



}