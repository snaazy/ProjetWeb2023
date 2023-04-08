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
    $formation->delete();
    return redirect()->route('admin.formations.index')->with('success', 'Formation supprimée avec succès');
}
}
