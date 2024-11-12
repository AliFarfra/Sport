<?php

// app/Http/Controllers/PackController.php

namespace App\Http\Controllers;

use App\Models\Pack;
use Illuminate\Http\Request;

class PackController extends Controller
{
    public function index()
    {
        $packs = Pack::all();
        return view('packs.index', compact('packs'));
    }

    public function create()
    {
        return view('packs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'nombre_jours' => 'required|integer',
        ]);

        Pack::create($request->all());
        return redirect()->route('packs.index')->with('success', 'Pack created successfully.');
    }

    public function edit(Pack $pack)
    {
        return view('packs.edit', compact('pack'));
    }

 

    public function destroy(Pack $pack)
    {
        $pack->delete();
        return redirect()->route('packs.index')->with('success', 'Pack deleted successfully.');
    }
}