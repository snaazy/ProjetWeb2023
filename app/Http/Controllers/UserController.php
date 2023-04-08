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
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }


    public function destroy(User $user)
{
    $user->delete();
    return redirect()->route('admin.users.index')->with('success', 'L\'utilisateur a été supprimé avec succès.');
}


}