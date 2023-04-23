<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Planning;
use Illuminate\Http\Request;

class PlanningController extends Controller
{
    public function create($course_id)
    {
        $course = Course::findOrFail($course_id);
        return view('plannings.create', compact('course'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cours_id' => 'required',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        Planning::create($request->all());

        return redirect()->route('planning.byCourse', $request->cours_id)
            ->with('success', 'Séance de cours créée avec succès');
    }

    public function edit($id)
    {
        $planning = Planning::findOrFail($id);
        return view('plannings.edit', compact('planning'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cours_id' => 'required',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        $planning = Planning::findOrFail($id);
        $planning->update($request->all());

        return redirect()->route('planning.byCourse', $request->cours_id)
            ->with('success', 'Séance de cours mise à jour avec succès');
    }

    public function destroy($id)
    {
        $planning = Planning::findOrFail($id);
        $planning->delete();

        return redirect()->route('planning.byCourse', $planning->cours_id)
            ->with('success', 'Séance de cours supprimée avec succès');
    }

    public function byCourse($course_id)
    {
        $course = Course::with('plannings')->findOrFail($course_id);
        return view('plannings.byCourse', compact('course'));
    }

    public function byWeek(Request $request)
    {
        // À compléter avec la logique pour récupérer les séances par semaine
    }
}
