<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');

        $query = User::query();

        if ($search) {
            $query->where('nom', 'LIKE', "%{$search}%")
                ->orWhere('prenom', 'LIKE', "%{$search}%")
                ->orWhere('login', 'LIKE', "%{$search}%");
        }

        if ($type) {
            $query->where('type', $type);
        }

        $users = $query->paginate(5);

        return view('admin.users.index', ['users' => $users]);
    }
    
    public function approveUser(Request $request, User $user)
    {
        $user->update([
            'type' => 'etudiant',
        ]);
    
        return redirect()->route('admin.users.index')->with('success', "L'utilisateur a été approuvé avec succès.");
    }
    



    public function update(Request $request, User $user)
    {
        $user->update(['type' => $request->input('type')]);
        return redirect()->route('admin.users.index')->with('success', 'Type utilisateur modifié avec succès.');
    }
    
    public function refuseUser(Request $request, User $user)
    {
        $user->update([
            'type' => NULL,
        ]);
        // $user->delete();
    
        return redirect()->route('admin.users.index')->with('success', "L'utilisateur a été refusé avec succès.");
    }
    

    
}
