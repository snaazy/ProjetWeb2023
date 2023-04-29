<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planning;
use App\Models\Cours;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{

    public function index(Request $request)
    {   
        // Récupère la valeur de la semaine sélectionnée
        $week = $request->input('week');
        // Récupère la valeur pour le tri par cours
        $sortByCourse = $request->input('sort_by_course');

        // Initialise la requête pour récupérer les séances de cours
        if (Auth::user()->type === 'admin') {
            // Si l'utilisateur est un administrateur, récupère toutes les séances de cours avec les informations du cours et de l'utilisateur associés
            $sessions = Planning::join('cours', 'plannings.cours_id', '=', 'cours.id')
                ->join('users', 'cours.user_id', '=', 'users.id')
                ->select('plannings.*', 'cours.intitule', 'users.nom', 'users.prenom');
        } else {
            // Sinon, récupère les séances de cours pour les cours enseignés par l'utilisateur connecté avec les informations du cours et de l'utilisateur associés
            $sessions = Planning::join('cours', 'plannings.cours_id', '=', 'cours.id')
                ->join('users', 'cours.user_id', '=', 'users.id')
                ->where('cours.user_id', '=', Auth::user()->id)
                ->select('plannings.*', 'cours.intitule', 'users.nom', 'users.prenom');
        }

        // Filtre les séances de cours par semaine si une semaine a été sélectionnée
        if ($week == 'current') {
            $startOfWeek = date('Y-m-d', strtotime('monday this week'));
            $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
            $sessions = $sessions->whereBetween('date_debut', [$startOfWeek, $endOfWeek]);
        }
        // Trie les séances de cours par cours si l'option est sélectionnée
        if ($sortByCourse) {
            $sessions = $sessions->orderBy('cours.intitule');
        }

        $sessions = $sessions->paginate(5);

        // Renvoie la vue avec les séances de cours paginées
        return view('sessions.index', compact('sessions'));
    }

    public function create()
    {
        $courses = Cours::all();
        $enseignants = User::where('type', 'enseignant')->get();
        return view('sessions.create', compact('courses', 'enseignants'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        // Conversion des dates de début et de fin en timestamp
        $dateDebut = strtotime($request->input('date_debut'));
        $dateFin = strtotime($request->input('date_fin'));
        // Calcule la durée de la séance de cours en heures
        $duree = ($dateFin - $dateDebut) / 3600;
        // Vérifie que la durée est valide (1h, 2h, 3h ou 4h)
        if (!in_array($duree, [1, 2, 3, 4])) {
             // Redirige l'utilisateur avec un message d'erreur si la durée n'est pas valide
            return redirect()->back()->withErrors(['La durée de la séance de cours doit être de 1h, 2h, 3h ou 4h. Ce sont les règles de l\'université !']);
        }
        // Récupère le cours associé à la séance de cours
        $course = Cours::findOrFail($request->input('course_id'));
        // Crée une nouvelle séance de cours avec les dates de début et de fin fournies
        $session = new Planning([
            'date_debut' => $request->input('date_debut'),
            'date_fin' => $request->input('date_fin'),
        ]);
        // Associe la nouvelle séance de cours au cours correspondant
        $course->plannings()->save($session);
        // Redirige l'utilisateur vers la liste des séances de cours avec un message de succès
        return redirect()->route('sessions.index', $course->id)->with('success', 'La séance de cours a été créée avec succès.');
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

        // Récupération de la séance de cours à modifier
        $session = Planning::findOrFail($id);
        $session->date_debut = $request->input('date_debut');
        $session->date_fin = $request->input('date_fin');
        $session->save();

        // Redirection vers la page des séances de cours avec un message de succès en fonction du type d'utilisateur
        if (Auth::user()->type == 'admin') {
            return redirect()->route('sessions.index')->with('success', 'La séance de cours a été modifiée avec succès.');
        } else {
            return redirect()->route('sessions.index', $session->cours->id)->with('success', 'La séance de cours a été modifiée avec succès.');
        }
    }


    public function destroy($id)
    {   
        // Récupère la séance de cours correspondant à l'id
        $session = Planning::findOrFail($id);
        // Récupère l'ID du cours associé à la séance de cours
        $courseId = $session->cours->id;
        // Supprime la séance de cours de la base de données
        $session->delete();

        return redirect()->route('sessions.index', $courseId)->with('success', 'La séance de cours a été supprimée avec succès.');
    }


    public function studentPlanning($week = null)
    {   
        // Récupère l'id de l'utilisateur actuel
        $user_id = auth()->id();
        // Récupère les séances de cours associées aux cours suivis par l'utilisateur actuel
        $sessions = Planning::join('cours', 'plannings.cours_id', '=', 'cours.id')
            ->join('cours_users', 'cours.id', '=', 'cours_users.cours_id')
            ->join('users', 'cours.user_id', '=', 'users.id')
            ->select('plannings.*', 'cours.intitule', 'users.nom', 'users.prenom')
            ->where('cours_users.user_id', $user_id)
            ->get();
        // Si la semaine n'est pas spécifiée, on prend la semaine courante
        if ($week == null) {
            $week = date('W');
        }

        // Retourne la vue qui affiche les séances de cours et la semaine courante 
        return view('sessions.etudiant', compact('week', 'sessions'));
    }

    public function studentPlanningTable(Request $request)
    {
        $user_id = auth()->id();
        // Récupération des paramètres de tri et de la semaine courante
        $sortByCourse = $request->input('sort_by_course');
        $week = $request->input('week');
        // Jointure des tables Planning, Cours, Cours_Users et Users pour récupérer les informations des sessions de cours
        $sessions = Planning::join('cours', 'plannings.cours_id', '=', 'cours.id')
            ->join('cours_users', 'cours.id', '=', 'cours_users.cours_id')
            ->join('users', 'cours.user_id', '=', 'users.id')
            ->select('plannings.*', 'cours.intitule', 'users.nom', 'users.prenom')
            ->where('cours_users.user_id', $user_id);
         // Tri des sessions de cours par cours si l'option de tri est activée
        if ($sortByCourse) {
            $sessions = $sessions->orderBy('cours.intitule');
        }
        // Filtrage des sessions de cours pour la semaine courante si l'option est activée
        if ($week == 'current') {
            $startOfWeek = date('Y-m-d', strtotime('monday this week'));
            $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
            $sessions = $sessions->whereBetween('date_debut', [$startOfWeek, $endOfWeek]);
        } else if ($week != null) { // Filtrage des sessions de cours pour une semaine spécifique si une semaine est spécifiée
            $sessions = $sessions->whereRaw('WEEK(plannings.date_debut) = ?', [$week])->orderBy('plannings.date_debut');
        }

        $sessions = $sessions->paginate(10);

        return view('sessions.etudiant_table', compact('week', 'sessions'));
    }










}