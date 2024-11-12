<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use App\Models\User;
use App\Models\Pack;
use App\Models\Cours;
use App\Models\Subscription;
use App\Models\Role;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdherentController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $adherents = Adherent::with(['subscriptions.pack', 'subscriptions.cours'])->get();
        return view('adherents.index', compact('adherents'));
    }

    public function dashboard()
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect('/login'); // Redirect to login if not authenticated
        }

        // Check if the authenticated user has the 'adherent' role
        if (!Auth::user()->hasRole('adherent')) {
            return redirect('/')->with('error', 'You do not have access to this page.'); // Redirect if not adherent
        }

        // Fetch all packs to pass to the view
        $packs = Pack::all();

        // Return the dashboard view for adherents
        return view('adherents.dashboard', compact('packs'));
    }

    // Example of an admin dashboard method (to restrict access)
    public function adminDashboard()
    {
        if (!Auth::check() || Auth::user()->hasRole('adherent')) {
            // Redirect if not authenticated or if the user is an adherent
            return redirect('/')->with('error', 'You do not have access to this page.');
        }

        // Admin logic here...
        return view('admin.dashboard');
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('adherents.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'cin' => 'required|string|unique:adherents,cin|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create Adherent
        $adherent = Adherent::create($request->only(['nom', 'prenom', 'date_naissance', 'cin']));

        // Create User and link to Adherent
        $user = User::create([
            'name' => $request->nom . ' ' . $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_adherent' => $adherent->id,
        ]);

        // Automatically assign the "adherent" role to the user
        Role::create([
            'id_user' => $user->id,
            'role' => 'adherent',
        ]);

        return redirect()->route('adherents.index')->with('success', 'Adherent and User created successfully with the "adherent" role.');
    }

    // Remove the specified resource from storage
    public function destroy(Adherent $adherent)
    {
        if ($adherent->user) {
            $adherent->user()->delete();
        }

        $adherent->delete();
        return redirect()->route('adherents.index')->with('success', 'Adherent and User deleted successfully.');
    }

    // Show the form for creating a new subscription
    public function createSubscription($userId)
    {
        $user = User::with('adherent')->find($userId);
    
        if (!$user) {
            return redirect()->route('adherents.index')->with('error', 'User not found.');
        }

        if (!$user->adherent) {
            return redirect()->route('adherents.index')->with('error', 'This user does not have an associated adherent.');
        }
    
        $packs = Pack::all();
        $cours = Cours::all();
        
        return view('adherents.create_subscription', [
            'adherent' => $user->adherent,
            'packs' => $packs,
            'cours' => $cours
        ]);
    }

    // Store a newly created subscription
    public function storeSubscription(Request $request)
    {
        $request->validate([
            'adherent_id' => 'required|exists:adherents,id',
            'pack_id' => 'required|exists:packs,id',
            'cours_id' => 'required|array',
            'cours_id.*' => 'exists:cours,id',
            'user_id' => 'required|exists:users,id',
        ]);
    
        foreach ($request->cours_id as $coursId) {
            Subscription::create([
                'adherent_id' => $request->adherent_id,
                'pack_id' => $request->pack_id,
                'cours_id' => $coursId,
                'user_id' => $request->user_id,
            ]);
        }
    
        return redirect()->route('adherents.index')->with('success', 'Subscription(s) created successfully.');
    }

    // Remove the specified subscription
    public function destroySubscription(Subscription $subscription)
    {
        $subscription->delete();
        return redirect()->route('adherents.index')->with('success', 'Subscription deleted successfully.');
    }

    public function createPayment($userId)
    {
        $user = User::with('adherent')->find($userId);

        // Check if the user exists and has an associated adherent
        if (!$user || !$user->adherent) {
            return redirect()->route('adherents.index')->with('error', 'User not found or does not have an associated adherent.');
        }

        // Fetch all available packs and courses
        $packs = Pack::all();
        $cours = Cours::all();

        // Return the payment creation view with the necessary data
        return view('adherents.create_paiement', compact('user', 'packs', 'cours'));
    }

    // Store the newly created payment
    public function storePayment(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'adherent_id' => 'required|exists:adherents,id',
            'pack_id' => 'required|exists:packs,id',
            'cours_id' => 'sometimes|array', // Make courses optional
            'cours_id.*' => 'exists:cours,id',
            'types_de_paiment' => 'required|in:cache,virement,carte_bancaire',
        ]);
    
        // Find the selected pack
        $pack = Pack::find($request->pack_id);
        
        // Initialize course total to 0
        $coursMontants = 0;
    
        // Check if courses are selected
        if ($request->has('cours_id')) {
            // Get the total amount for the selected courses
            $coursMontants = Cours::whereIn('id', $request->cours_id)->pluck('prix')->sum();
        }
    
        // Retrieve the user linked to the selected adherent
        $user = User::where('id_adherent', $request->adherent_id)->first();
    
        // Create the payment record
        Paiement::create([
            'user_id' => $user->id, // Use the user ID linked to the selected adherent
            'date_de_paiment' => now(),
            'pack_montant' => $pack->prix, // Store the pack amount
            'cours_montant' => $coursMontants, // Store the total course amount (0 if no courses selected)
            'types_de_paiment' => $request->types_de_paiment,
        ]);
    
        // Redirect back to the adherents index with a success message
        return redirect()->route('adherents.index')->with('success', 'Payment created successfully.');
    }
}