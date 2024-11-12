<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $cours = Cours::all();
        return view('cours.index', compact('cours'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('cours.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
        ]);

        Cours::create($request->all());
        return redirect()->route('cours.index')->with('success', 'Course created successfully.');
    }

    // Remove the specified resource from storage
    public function destroy(Cours $cours)
    {
        $cours->delete();
        return redirect()->route('cours.index')->with('success', 'Course deleted successfully.');
    }
    public function showPacks()
    {
        $user = Auth::user();

        // Check if the user has the "adherent" role
        if ($user->roles()->where('role', 'adherent')->exists()) {
            // Get the adherent associated with the authenticated user
            $adherent = $user->adherent;

            if ($adherent) {
                // Fetch packs associated with the adherent through subscriptions
                $packs = $adherent->subscriptions()->with('pack')->get()->pluck('pack')->unique('id');
                return view('packs.index', compact('packs'));
            } else {
                return redirect()->route('home')->with('error', 'No associated adherent found.');
            }
        }

        return redirect()->route('home')->with('error', 'You do not have access to view this content.');
    }

    public function showCourses()
    {
        $user = Auth::user();

        // Check if the user has the "adherent" role
        if ($user->roles()->where('role', 'adherent')->exists()) {
            // Get the adherent associated with the authenticated user
            $adherent = $user->adherent;

            if ($adherent) {
                // Fetch courses associated with the adherent through subscriptions
                $courses = $adherent->subscriptions()->with('cours')->get()->pluck('cours')->unique('id');
                return view('cours.index', compact('courses'));
            } else {
                return redirect()->route('home')->with('error', 'No associated adherent found.');
            }
        }

        return redirect()->route('home')->with('error', 'You do not have access to view this content.');
    }
}