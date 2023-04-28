<?php

namespace App\Http\Controllers;

use App\Models\Formation;
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




    public function updateType(Request $request, User $user)
    {
        $user->update(['type' => $request->input('type')]);
        return redirect()->route('admin.users.index')->with('success', 'Type utilisateur modifié avec succès.');
    }

    public function refuseUser(Request $request, User $user)
    {
        $user->update([
            'type' => NULL,
        ]);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "L'utilisateur a été refusé avec succès.");
    }

    public function showChangePasswordUserForm(User $user)
    {
        return view('admin.users.changepassword', compact('user'));
    }

    public function changePasswordUser(Request $request, User $user)
    {
        $request->validate([
            'new_password' => 'required|min:2',
            'new_password_confirmation' => 'required|same:new_password',
        ]);
    
        $user->mdp = bcrypt($request->input('new_password'));
        $user->save();
    
        $successMessage = 'Le mot de passe de l\'utilisateur a été modifié avec succès.';
        return redirect()->route('admin.users.index')->with(compact('successMessage'));
    }
    
    



    public function updateUser(Request $request, User $user)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'login' => 'required|string|max:255|unique:users,login,' . $user->id,
    ]);

    $user->nom = $request->nom;
    $user->prenom = $request->prenom;
    $user->login = $request->login;
    $user->save();

    return redirect()->back()->with('success', 'Les informations de l\'utilisateur ont été mises à jour.');
}

public function showCreateUserForm()
{
    $formations = Formation::all();
    return view('admin.create-user', ['formations' => $formations]);
}
public function create(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:40',
        'prenom' => 'required|string|max:40',
        'login' => 'required|string|max:30|unique:users',
        'mdp' => 'required|string|min:1',
        'type' => 'required|in:etudiant,enseignant,admin',
        'formation_id' => 'nullable|exists:formations,id'
    ]);

    $formation_id = $request->input('formation_id');
    $type = $request->input('type');

    if ($type == 'admin') {
        $formation_id = null;
    } elseif ($type == 'enseignant') {
        $formation_id = null;
    } else {
        $request->validate([
            'formation_id' => 'required|exists:formations,id'
        ]);
    }

    User::create([
        'nom' => $request->input('nom'),
        'prenom' => $request->input('prenom'),
        'login' => $request->input('login'),
        'mdp' => bcrypt($request->input('mdp')),
        'formation_id' => $formation_id,
        'type' => $type
    ]);

    return redirect('/admin')->with('success', 'Utilisateur créé avec succès.');
}
}