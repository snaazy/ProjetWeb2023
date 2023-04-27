<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planning;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller

{

    public function index(Request $request)
    {
        $week = $request->input('week');
        $sortByCourse = $request->input('sort_by_course');
        
        $sessions = Planning::join('cours', 'plannings.cours_id', '=', 'cours.id')
                    ->join('users', 'cours.user_id', '=', 'users.id')
                    ->where('cours.user_id', '=', Auth::user()->id)
                    ->select('plannings.*', 'cours.intitule', 'users.nom', 'users.prenom');
        
        if ($week == 'current') {
            $startOfWeek = date('Y-m-d', strtotime('monday this week'));
            $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
            $sessions = $sessions->whereBetween('date_debut', [$startOfWeek, $endOfWeek]);
        }
        
        if ($sortByCourse) {
            $sessions = $sessions->orderBy('cours.intitule');
        }
        
        $sessions = $sessions->paginate(5);
        
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

    $dateDebut = strtotime($request->input('date_debut'));
    $dateFin = strtotime($request->input('date_fin'));
    $duree = ($dateFin - $dateDebut) / 3600;

    if (!in_array($duree, [1, 2, 3, 4])) {
        return redirect()->back()->withErrors(['La durée de la séance de cours doit être de 1h, 2h, 3h ou 4h. Ce sont les règles de l\'université !']);
    }

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
    
        $dateDebut = strtotime($request->input('date_debut'));
        $dateFin = strtotime($request->input('date_fin'));
        $duree = ($dateFin - $dateDebut) / 3600;
    
        if (!in_array($duree, [1, 2, 3, 4])) {
            return redirect()->back()->withErrors(['La durée de la séance de cours doit être de 1h, 2h, 3h ou 4h. Ce sont les règles de l\'université !']);
        }
    
        $session = Planning::findOrFail($id);
        $session->date_debut = $request->input('date_debut');
        $session->date_fin = $request->input('date_fin');
        $session->save();
    
        return redirect()->route('sessions.index', $session->cours->id)->with('success', 'La séance de cours a été modifiée avec succès.');
    }

    public function destroy($id)
    {
        $session = Planning::findOrFail($id);
        $courseId = $session->cours->id;
        $session->delete();

        return redirect()->route('sessions.index', $courseId)->with('success', 'La séance de cours a été supprimée avec succès.');
    }


    public function studentPlanning($week = null)
    {
        $user_id = auth()->id();
        $sessions = Planning::join('cours', 'plannings.cours_id', '=', 'cours.id')
                    ->join('cours_users', 'cours.id', '=', 'cours_users.cours_id')
                    ->join('users', 'cours.user_id', '=', 'users.id')
                    ->select('plannings.*', 'cours.intitule', 'users.nom', 'users.prenom')
                    ->where('cours_users.user_id', $user_id)
                    ->get();
        
        if ($week == null) {
            $week = date('W');
        }
        
        
        return view('sessions.etudiant', compact('week', 'sessions'));
    }

    public function studentPlanningTable(Request $request)
    {
        $user_id = auth()->id();
        $sortByCourse = $request->input('sort_by_course');
        $week = $request->input('week');
        
        $sessions = Planning::join('cours', 'plannings.cours_id', '=', 'cours.id')
                    ->join('cours_users', 'cours.id', '=', 'cours_users.cours_id')
                    ->join('users', 'cours.user_id', '=', 'users.id')
                    ->select('plannings.*', 'cours.intitule', 'users.nom', 'users.prenom')
                    ->where('cours_users.user_id', $user_id);
            
        if ($sortByCourse) {
            $sessions = $sessions->orderBy('cours.intitule');
        }
            
        if ($week == 'current') {
            $startOfWeek = date('Y-m-d', strtotime('monday this week'));
            $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
            $sessions = $sessions->whereBetween('date_debut', [$startOfWeek, $endOfWeek]);
        } else if ($week != null) {
            $sessions = $sessions->whereRaw('WEEK(plannings.date_debut) = ?', [$week])->orderBy('plannings.date_debut');
        }
            
        $sessions = $sessions->paginate(10);
            
        return view('sessions.etudiant_table', compact('week', 'sessions'));
    }
    

    

    
    

    
    
    


    
}
