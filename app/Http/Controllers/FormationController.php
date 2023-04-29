<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;
class FormationController extends Controller
{
    
public function index()
{
    $formations = Formation::all();
    return view('admin.formations.index', compact('formations'));
}

public function create()
{
    return view('admin.formations.create');
}

public function store(Request $request)
{   
    // Validation des champs
    $request->validate([
        'intitule' => 'required|string|max:255|unique:formations',
    ]);

    // Création de la formation en base de données
    Formation::create([
        'intitule' => $request->input('intitule'),
    ]);
    // Redirection vers la page d'index des formations avec un message de succès
    return redirect()->route('admin.formations.index')->with('success', 'Formation créée avec succès');
}

public function edit(Formation $formation)
{
    return view('admin.formations.edit', compact('formation'));
}

public function update(Request $request, Formation $formation)
{
    $request->validate([
        'intitule' => 'required|string|max:255|unique:formations,intitule,' . $formation->id,
    ]);
    // Mise à jour de l'intitulé de la formation dans la base de données
    $formation->update([
        'intitule' => $request->input('intitule'),
    ]);

    return redirect()->route('admin.formations.index')->with('success', 'Formation mise à jour avec succès');
}

public function destroy(Formation $formation)
{
    try {
        // Compte le nombre d'étudiants inscrits dans la formation
        $count = $formation->users()->where('type', 'etudiant')->count();

        if ($count > 0) {
            // Si des étudiants sont inscrits, les affecte au type null
            $formation->users()->where('type', 'etudiant')->update(['type' => null]);
            $message = 'La formation a été supprimée avec succès. '.$count.' étudiant(s) ont été affecté(s) au type null.';
        } else {
            // Si aucun étudiant n'est inscrit, supprime simplement la formation
            $formation->delete();
            $message = 'Formation supprimée avec succès.';
        }
        // Redirige vers la liste des formations avec un message de succès
        return redirect()->route('admin.formations.index')->with('success', $message);
    } catch (\Illuminate\Database\QueryException $e) {
        $errorCode = $e->errorInfo[1];
        // Vérifie le code d'erreur pour détecter une violation de contrainte de clé étrangère
        if ($errorCode == 1451) {
            // Si une violation de contrainte de clé étrangère est détectée, redirige avec un message d'avertissement
            return redirect()->route('admin.formations.index')->with('warning', 'Impossible de supprimer la formation car des données y sont liées. Veuillez vous assurer que toutes les données liées à cette formation, comme les cours et les séances de cours associées, ont été supprimées avant de procéder à la suppression de la formation.');
        } else {
            // Si une autre erreur se produit,redirige egalement avec un message d'erreur
            return redirect()->route('admin.formations.index')->with('warning', 'Impossible de supprimer la formation car des données y sont liées. Veuillez vous assurer que toutes les données liées à cette formation, comme les cours et les séances de cours associées, ont été supprimées ou déplacées avant de procéder à la suppression de la formation.');
        }
    }
}



}
