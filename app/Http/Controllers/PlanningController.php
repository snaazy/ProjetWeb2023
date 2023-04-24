<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planning;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;



class PlanningController extends Controller
{

    public function index()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
    
        // Vérifier si l'utilisateur est un enseignant ou un étudiant
        if ($user->type == 'enseignant') {
            // Récupérer toutes les séances de cours associées à l'enseignant
            $plannings = Planning::whereIn('cours_id', $user->cours->pluck('id'))->get();
        } else {
            // Récupérer toutes les séances de cours associées à l'étudiant
            $plannings = Planning::whereIn('cours_id', $user->cours->pluck('id'))->get();
        }
        
        // Récupérer tous les cours pour les afficher dans le formulaire de création
        $courses = Course::all();
    
        return view('planning.index', compact('plannings', 'courses'));
    }
    


public function store(Request $request)
{
    $planning = new Planning();
    $planning->cours_id = $request->input('cours_id');
    $planning->date_debut = $request->input('date_debut');
    $planning->date_fin = $request->input('date_fin');
    $planning->save();

    return redirect()->back()->with('success', 'La séance de cours a été créée avec succès.');
}

public function create()
{
    // Récupérer tous les cours pour les afficher dans le formulaire de création
    $courses = Course::all();

    return view('planning.create', compact('courses'));
}


    public function edit(Request $request, $id)
    {
        $planning = Planning::find($id);
        $planning->date_debut = $request->input('date_debut');
        $planning->date_fin = $request->input('date_fin');
        $planning->save();

        return redirect()->back()->with('success', 'La séance de cours a été mise à jour avec succès.');
    }

    public function delete($id)
    {
        $planning = Planning::find($id);
        $planning->delete();

        return redirect()->back()->with('success', 'La séance de cours a été supprimée avec succès.');
    }
}
