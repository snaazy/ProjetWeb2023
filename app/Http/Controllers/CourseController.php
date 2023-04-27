<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Formation;



class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with(['formation', 'user']);
    
        if ($request->input('q')) {
            $query->where('intitule', 'like', '%' . $request->input('q') . '%');
        }
    
        if ($request->input('enseignant')) {
            $query->where('user_id', $request->input('enseignant'));
        }
    
        $cours = $query->paginate(5);
    
        $enseignants = User::where('type', 'enseignant')->get();
    
        return view('cours.index', compact('cours', 'enseignants'));
    }
    
    

    public function create()
    {
        $formations = Formation::all();
        $enseignants = User::where('type', 'enseignant')->get();
        return view('cours.create', compact('formations', 'enseignants'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'intitule' => 'required|string|max:50|min:5',
            'formation_id' => 'required|integer|exists:formations,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);
    
        $course = new Course([
            'intitule' => $request->input('intitule'),
            'formation_id' => $request->input('formation_id'),
            'user_id' => $request->input('user_id'),
        ]);
    
        $course->save();
    
        return redirect()->route('cours.index')->with('success', 'Le cours a été créé avec succès et l\'enseignant a été associé.');
    }
/* 
    public function show($id)
{
    $course = Course::with(['formation', 'user'])->findOrFail($id);
    return view('cours.show', compact('course'));
} */

public function show($id)
{
    $course = Course::with(['formation', 'user', 'plannings'])->findOrFail($id);
    return view('cours.show', compact('course'));
}



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
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
    
        $course = Course::findOrFail($id);
        $course->intitule = $request->intitule;
        $course->user_id = $request->user_id;
        $course->save();
    
        return redirect()->route('cours.index', $course->id)->with('success', 'Le cours a été modifié avec succès.');
    }
    

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
    
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
    
        $courses = Course::with(['formation', 'user'])
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
    $course = Course::findOrFail($id);

    if ($user->courses->contains($course)) {
        return redirect()->route('student.courses')->with('warning', 'Vous êtes déjà inscrit à ce cours.');
    }

    $course->students()->attach($user->id);

    return redirect()->route('student.courses')->with('success', 'Vous êtes maintenant inscrit au cours.');
}


public function unenroll(int $id)
{
    $user = auth()->user();
    $course = Course::findOrFail($id);

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
