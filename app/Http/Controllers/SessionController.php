<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planning;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller

{


    public function index()
    {
        $sessions = Planning::join('cours', 'plannings.cours_id', '=', 'cours.id')
                    ->join('users', 'cours.user_id', '=', 'users.id')
                    ->select('plannings.*', 'cours.intitule', 'users.nom', 'users.prenom')
                    ->get();
        return view('sessions.index', compact('sessions'));
    }
    


    public function create()
    {
        $courses = Course::all();
        return view('sessions.create', compact('courses'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
           
        ]);
    
        $course = Course::findOrFail($request->input('course_id'));
    
        $session = new Planning([
            'date_debut' => $request->input('date_debut'),
            'date_fin' => $request->input('date_fin'),
        ]);
    
        $course->plannings()->save($session);
    
        return redirect()->route('cours.show', $course->id)->with('success', 'La séance de cours a été créée avec succès.');
    }
    

    public function edit($id)
    {
        $session = Planning::findOrFail($id);
        return view('sessions.edit', compact('session'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        $session = Planning::findOrFail($id);
        $session->date_debut = $request->input('date_debut');
        $session->date_fin = $request->input('date_fin');
        $session->save();

        return redirect()->route('cours.show', $session->cours->id)->with('success', 'La séance de cours a été modifiée avec succès.');
    }

    public function destroy($id)
    {
        $session = Planning::findOrFail($id);
        $courseId = $session->cours->id;
        $session->delete();

        return redirect()->route('sessions.index', $courseId)->with('success', 'La séance de cours a été supprimée avec succès.');
    }



  

    
}
