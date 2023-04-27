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
    $request->validate([
        'intitule' => 'required|string|max:255|unique:formations',
    ]);

    Formation::create([
        'intitule' => $request->input('intitule'),
    ]);

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

    $formation->update([
        'intitule' => $request->input('intitule'),
    ]);

    return redirect()->route('admin.formations.index')->with('success', 'Formation mise à jour avec succès');
}

public function destroy(Formation $formation)
{
    try {
        $count = $formation->users()->where('type', 'etudiant')->count();

        if ($count > 0) {
            $formation->users()->where('type', 'etudiant')->update(['type' => null]);
            $message = 'La formation a été supprimée avec succès. '.$count.' étudiant(s) ont été affecté(s) au type null.';
        } else {
            $formation->delete();
            $message = 'Formation supprimée avec succès.';
        }

        return redirect()->route('admin.formations.index')->with('success', $message);
    } catch (\Illuminate\Database\QueryException $e) {
        $errorCode = $e->errorInfo[1];
        if ($errorCode == 1451) {
            return redirect()->route('admin.formations.index')->with('warning', 'Impossible de supprimer la formation car des données y sont liées. Veuillez vous assurer que toutes les données liées à cette formation, comme les cours et les séances de cours associées, ont été supprimées avant de procéder à la suppression de la formation.');
        } else {
            return redirect()->route('admin.formations.index')->with('warning', 'Impossible de supprimer la formation car des données y sont liées. Veuillez vous assurer que toutes les données liées à cette formation, comme les cours et les séances de cours associées, ont été supprimées ou déplacées avant de procéder à la suppression de la formation.');
        }
    }
}



}
