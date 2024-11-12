<?php

namespace App\Http\Controllers;

use App\Models\Administrateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class AdministrateurController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $administrateurs = Administrateur::all();
        return view('administrateurs.index', compact('administrateurs'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('administrateurs.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'date_debut' => 'required|date',
        'matricule' => 'required|string|unique:administrateurs,matricule|max:255',
        'type' => 'required|in:secretaire,coach,femme_de_menage',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // Create Administrateur
    $administrateur = Administrateur::create($request->only(['nom', 'prenom', 'date_debut', 'matricule', 'type']));

    // Create User and link to Administrateur
    $user = User::create([
        'name' => $request->nom . ' ' . $request->prenom,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'id_administrateur' => $administrateur->id, // Link the user to the administrateur
    ]);

    return redirect()->route('administrateurs.index')->with('success', 'Administrateur and User created successfully.');
}
    // Remove the specified resource from storage
    public function destroy(Administrateur $administrateur)
    {
        // Optionally delete the user associated with the administrateur
        if ($administrateur->user) {
            $administrateur->user->delete();
        }
    
        $administrateur->delete();
        return redirect()->route('administrateurs.index')->with('success', 'Administrateur and User deleted successfully.');
    }
}