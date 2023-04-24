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
    $sessions = Planning::all();
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
            'cours_id' => 'required|integer|exists:cours,id',
            'date_debut' => 'required|date|before:date_fin',
            'date_fin' => 'required|date|after:date_debut',
        ]);
    
        $session = new Session([
            'cours_id' => $request->input('cours_id'),
            'date_debut' => $request->input('date_debut'),
            'date_fin' => $request->input('date_fin'),
        ]);
    
        // Récupérer l'utilisateur connecté et l'associer à la nouvelle séance de cours
        $user = auth()->user();
        $session->user()->associate($user);
    
        $session->save();
    
        return redirect()->route('sessions.index')->with('success', 'La séance de cours a été créée avec succès.');
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

        return redirect()->route('sessions.show', $courseId)->with('success', 'La séance de cours a été supprimée avec succès.');
    }

  

}
