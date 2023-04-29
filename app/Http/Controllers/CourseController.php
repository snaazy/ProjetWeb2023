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
        $course = Cours::with(['formation', 'user', 'plannings'])->findOrFail($id);
        return view('cours.show', compact('course'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $course = Cours::findOrFail($id);
        $formations = Formation::all();
        $enseignants = User::where('type', 'enseignant')->get();
        return view('cours.edit', compact('course', 'formations', 'enseignants'));
    }
    
   
    public function update(Request $request, $id)
    {
        $request->validate([
            'intitule' => 'required',
            'user_id' => 'required',
        ]);
    
        $course = Cours::findOrFail($id);
        $course->intitule = $request->intitule;
        $course->user_id = $request->user_id;
        $course->save();
    
        return redirect()->route('cours.index', $course->id)->with('success', 'Le cours a été modifié avec succès.');
    }
    

    public function destroy($id)
    {
        $course = Cours::findOrFail($id);
    
        // Supprime les séances de cours associées
        foreach ($course->plannings as $session) {
            $session->delete();
        }
    
        // Désinscrire tous les étudiants inscrits à ce cours
        $course->students()->detach();
    
        $course->delete();
    
        return redirect()->route('cours.index')->with('success', 'Le cours a été supprimé avec succès.');
    }
    

    public function studentCourses(Request $request)
    {
        $user = auth()->user();
        $formation_id = $user->formation_id;
        $search = $request->input('search');
    
        $courses = Cours::with(['formation', 'user'])
                        ->where('formation_id', $formation_id)
                        ->when($search, function ($query, $search) {
                            return $query->where('intitule', 'like', '%' . $search . '%');
                        })
                        ->paginate(3);
    
        return view('cours.student', compact('courses'));
    }
    

public function enroll(int $id)
{
    $user = auth()->user();
    $course = Cours::findOrFail($id);

    if ($user->courses->contains($course)) {
        return redirect()->route('student.courses')->with('warning', 'Vous êtes déjà inscrit à ce cours.');
    }

    $course->students()->attach($user->id);

    return redirect()->route('student.courses')->with('success', 'Vous êtes maintenant inscrit au cours.');
}


public function unenroll(int $id)
{
    $user = auth()->user();
    $course = Cours::findOrFail($id);

    if (!$user->courses->contains($id)) {
        return redirect()->route('student.courses')->with('warning', 'Vous n\'êtes pas inscrit à ce cours.');
    }
    
    $course->students()->detach($user->id);
    
    return redirect()->route('student.courses')->with('danger', 'Vous êtes désinscrit du cours.');
    
}


public function myCourses() 
{
    $user = auth()->user();
    $courses = $user->courses()->with(['formation', 'user'])->get();

    return view('cours.mycourses', compact('courses'));
}




}
