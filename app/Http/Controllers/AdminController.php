<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {   
        // Applique le middleware d'authentification pour toutes les méthodes de ce contrôleur
        $this->middleware('auth');
    }

    /**
     * Affiche la liste des utilisateurs.
     *
     */
    public function index(Request $request)
    {   
        // Récupère les valeurs de recherche et de type à partir de la requête
        $search = $request->input('search');
        $type = $request->input('type');

        // Initialise une nouvelle requête pour les utilisateurs
        $query = User::query();
        
        // Si une recherche est spécifiée, filtre les utilisateurs par nom, prénom ou login
        if ($search) {
            $query->where('nom', 'LIKE', "%{$search}%")
                ->orWhere('prenom', 'LIKE', "%{$search}%")
                ->orWhere('login', 'LIKE', "%{$search}%");
        }

        // Si un type est spécifié, filtre les utilisateurs par type
        if ($type) {
            $query->where('type', $type);
        }

        // Exécute la requête et récupère les utilisateurs paginés
        $users = $query->paginate(5);
        // Compte le nombre d'utilisateurs en attente
        $enAttente = User::whereNull('type')->count();

        // Retourne la vue avec les utilisateurs et le nombre d'utilisateurs en attente
        return view('admin.users.index', compact('users', 'enAttente'));
    }

    /**
     * Approuve un utilisateur.
     *
     */
    public function approveUser(Request $request, User $user)
    {   
        // Met à jour le type de l'utilisateur en tant qu'étudiant
        $user->update([
            'type' => 'etudiant',
        ]);
        // Redirige vers la page de la liste des utilisateurs avec un message de succès
        return redirect()->route('admin.users.index')->with('success', "L'utilisateur a été approuvé avec succès.");
    }

     /**
     * Met à jour le type d'un utilisateur.
     *
     */
    public function updateType(Request $request, User $user)
    {   
         // Met à jour le type de l'utilisateur avec la valeur fournie par la requête
        $user->update(['type' => $request->input('type')]);
        // Redirige vers la page de la liste des utilisateurs avec un message de succès
        return redirect()->route('admin.users.index')->with('success', 'Type utilisateur modifié avec succès.');
    }

    /**
     * Refuse un utilisateur.
     *
     */
    public function refuseUser(Request $request, User $user)
    {
        // Met à jour le type de l'utilisateur à NULL (non approuvé)
        $user->update([
            'type' => NULL,
        ]);
        // Supprime l'utilisateur de la base de données
        $user->delete();
        // Redirige vers la page de la liste des utilisateurs avec un message de succès
        return redirect()->route('admin.users.index')->with('success', "L'utilisateur a été refusé avec succès.");
    }

    /**
     * Affiche le formulaire de changement de mot de passe d'un utilisateur.
     *
     */
    public function showChangePasswordUserForm(User $user)
    {
        return view('admin.users.changepassword', compact('user'));
    }
     /**
     * Changer le mot de passe d'un utilisateur.
     *
     */
    public function changePasswordUser(Request $request, User $user)
    {   
        // Valide les données du formulaire de changement de mot de passe
        $request->validate([
            'new_password' => 'required|min:2',
            'new_password_confirmation' => 'required|same:new_password',
        ]);
        // Chiffre le nouveau mot de passe et met à jour l'utilisateur
        $user->mdp = bcrypt($request->input('new_password'));
        // Enregistre les modifications de l'utilisateur dans la base de données
        $user->save();
        // Prépare un message de succès
        $successMessage = 'Le mot de passe de l\'utilisateur a été modifié avec succès.';
        // Redirige vers la page de la liste des utilisateurs avec un message de succès
        return redirect()->route('admin.users.index')->with(compact('successMessage'));
    }
     /**
     * Met à jour les informations d'un utilisateur.
     *
     */
    public function updateUser(Request $request, User $user)
    {   
        // Valide les données du formulaire de mise à jour d'utilisateur
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'login' => 'required|string|max:255|unique:users,login,' . $user->id,
        ]);
        // Met à jour les informations de l'utilisateur avec les données du formulaire
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->login = $request->login;
        // Enregistre les modifications de l'utilisateur dans la base de données
        $user->save();
        // Redirige vers la page précédente avec un message de succès
        return redirect()->back()->with('success', 'Les informations de l\'utilisateur ont été mises à jour.');
    }

     /**
     * Affiche le formulaire de création d'utilisateur.
     *
     */
    public function showCreateUserForm()
    {
        $formations = Formation::all();
        return view('admin.create-user', ['formations' => $formations]);
    }
     /**
     * Crée un nouvel utilisateur.
     *
     */
    public function create(Request $request)
    {   
         // Valide les données du formulaire de création d'utilisateur
        $request->validate([
            'nom' => 'required|string|max:40',
            'prenom' => 'required|string|max:40',
            'login' => 'required|string|max:30|unique:users',
            'mdp' => 'required|string|min:1',
            'type' => 'required|in:etudiant,enseignant,admin',
            'formation_id' => 'nullable|exists:formations,id'
        ]);

        // Récupère l'ID de la formation et le type d'utilisateur du formulaire
        $formation_id = $request->input('formation_id');
        $type = $request->input('type');

        // Si le type d'utilisateur est 'admin' ou 'enseignant', met la formation_id à null
        if ($type == 'admin') {
            $formation_id = null;
        } elseif ($type == 'enseignant') {
            $formation_id = null;
        } else {
            // Sinon, valide que la formation_id est bien renseignée et existe dans la table 'formations'
            $request->validate([
                'formation_id' => 'required|exists:formations,id'
            ]);
        }

        // Crée le nouvel utilisateur avec les données du formulaire
        User::create([
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'login' => $request->input('login'),
            'mdp' => bcrypt($request->input('mdp')),  // Hache le mot de passe avant de l'enregistrer
            'formation_id' => $formation_id,
            'type' => $type
        ]);
        // Redirige vers la page d'administration avec un message de succès
        return redirect('/admin')->with('success', 'Utilisateur créé avec succès.');
    }
}