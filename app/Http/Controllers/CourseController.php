<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cours;
use App\Models\Formation;



class CourseController extends Controller
{
    public function index(Request $request)
    {   
        // Initialise la requête pour récupérer les cours avec leurs relations formation et utilisateur
        $query = Cours::with(['formation', 'user']);

        // Si une chaîne de recherche est fournie, filtre les cours en fonction de leur intitulé
        if ($request->input('q')) {
            $query->where('intitule', 'like', '%' . $request->input('q') . '%');
        }
        // Si un enseignant est spécifié, filtre les cours en fonction de l'ID de l'enseignant
        if ($request->input('enseignant')) {
            $query->where('user_id', $request->input('enseignant'));
        }
        // Pagination des résultats de la requête
        $cours = $query->paginate(5);
        // Récupère tous les enseignants
        $enseignants = User::where('type', 'enseignant')->get();
        // Retourne la vue avec les cours et les enseignants
        return view('cours.index', compact('cours', 'enseignants'));
    }
    
    

    public function create()
    {   
        // Récupère toutes les formations
        $formations = Formation::all();
        // Récupère tous les enseignants
        $enseignants = User::where('type', 'enseignant')->get();
        // Retourne la vue pour créer un nouveau cours avec les formations et les enseignants
        return view('cours.create', compact('formations', 'enseignants'));
    }
    

    public function store(Request $request)
    {   
        // Valide les données de la requête
        $request->validate([
            'intitule' => 'required|string|max:50|min:5',
            'formation_id' => 'required|integer|exists:formations,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);
        // Crée une nouvelle instance de Cours avec les données de la requête
        $course = new Cours([
            'intitule' => $request->input('intitule'),
            'formation_id' => $request->input('formation_id'),
            'user_id' => $request->input('user_id'),
        ]);
        // Sauvegarde l'instance de Cours dans la base de données
        $course->save();
        // Redirige vers la liste des cours avec un message de succès
        return redirect()->route('cours.index')->with('success', 'Le cours a été créé avec succès et l\'enseignant a été associé.');
    }


    public function show($id)
    {   
        // Récupère le cours avec ses relations 'formation', 'user', et 'plannings' à partir de l'ID fourni, ou génère une erreur si non trouvé
        $course = Cours::with(['formation', 'user', 'plannings'])->findOrFail($id);
        // Retourne la vue 'cours.show' avec le cours récupéré
        return view('cours.show', compact('course'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {   
        // Récupère le cours à partir de l'ID fourni, ou génère une erreur si non trouvé
        $course = Cours::findOrFail($id);
        // Récupère toutes les formations
        $formations = Formation::all();
        // Récupère tous les utilisateurs de type 'enseignant'
        $enseignants = User::where('type', 'enseignant')->get();
        // Retourne la vue 'cours.edit' avec le cours récupéré, les formations et les enseignants
        return view('cours.edit', compact('course', 'formations', 'enseignants'));
    }
    
    public function update(Request $request, $id)
    {
        // Valide les données reçues dans la requête
        $request->validate([
            'intitule' => 'required',
            'user_id' => 'required',
        ]);
        
        // Récupère le cours à partir de l'ID fourni, ou génère une erreur si non trouvé
        $course = Cours::findOrFail($id);
        // Met à jour l'intitulé et l'ID de l'utilisateur du cours avec les données reçues
        $course->intitule = $request->intitule;
        $course->user_id = $request->user_id;
        // Enregistre les modifications apportées au cours
        $course->save();
        // Redirige vers la liste des cours avec un message de succès
        return redirect()->route('cours.index', $course->id)->with('success', 'Le cours a été modifié avec succès.');
    }
    

    public function destroy($id)
    {   
        // Récupère le cours à partir de l'ID fourni, ou génère une erreur si non trouvé
        $course = Cours::findOrFail($id);
    
        // Supprime les séances de cours associées
        foreach ($course->plannings as $session) {
            $session->delete();
        }
    
        // Désinscrire tous les étudiants inscrits à ce cours
        $course->students()->detach();
        // Supprime le cours
        $course->delete();
        // Redirige vers la liste des cours avec un message de succès
        return redirect()->route('cours.index')->with('success', 'Le cours a été supprimé avec succès.');
    }
    

    public function studentCourses(Request $request)
    {   
        // Récupère l'utilisateur connecté
        $user = auth()->user();
        // Récupère l'ID de la formation de l'étudiant
        $formation_id = $user->formation_id;
        // Récupère la valeur de la recherche à partir de la requête
        $search = $request->input('search');
        // Construit la requête pour récupérer les cours correspondant à la formation de l'étudiant
        $courses = Cours::with(['formation', 'user'])
                        ->where('formation_id', $formation_id)
                        ->when($search, function ($query, $search) {
                            return $query->where('intitule', 'like', '%' . $search . '%');
                        })
                        ->paginate(3);
        // Retourne la vue 'cours.student' avec les cours récupérés
        return view('cours.student', compact('courses'));
    }
    

public function enroll(int $id)
{   
    // On récupère l'utilisateur connecté
    $user = auth()->user();
    // On trouve le cours spécifique à l'aide de l'ID passé en paramètre
    $course = Cours::findOrFail($id);
    // Si l'utilisateur est déjà inscrit au cours, on redirige vers la liste des cours avec un message d'avertissement
    if ($user->courses->contains($course)) {
        return redirect()->route('student.courses')->with('warning', 'Vous êtes déjà inscrit à ce cours.');
    }
    // On inscrit l'utilisateur au cours en utilisant la méthode attach() 
    $course->students()->attach($user->id);
    // On redirige vers la liste des cours avec un message de succès
    return redirect()->route('student.courses')->with('success', 'Vous êtes maintenant inscrit au cours.');
}


public function unenroll(int $id)
{   
    // Récupérer l'utilisateur authentifié
    $user = auth()->user();
    // Récupérer le cours correspondant à l'ID fourni
    $course = Cours::findOrFail($id);
    // Si l'utilisateur n'est pas inscrit à ce cours, rediriger avec un message d'avertissement
    if (!$user->courses->contains($id)) {
        return redirect()->route('student.courses')->with('warning', 'Vous n\'êtes pas inscrit à ce cours.');
    }
    // Désinscrire l'utilisateur du cours
    $course->students()->detach($user->id);
    // Rediriger avec un message de succès
    return redirect()->route('student.courses')->with('danger', 'Vous êtes désinscrit du cours.');
    
}




}
