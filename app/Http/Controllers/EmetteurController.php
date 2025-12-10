<?php

namespace App\Http\Controllers;

use App\Models\Emetteur;
use Illuminate\Http\Request;

class EmetteurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emetteurs = Emetteur::paginate(10);
        return view('emetteurs.index', compact('emetteurs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('emetteurs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'required|email|unique:emetteurs,email',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'code_postal' => 'nullable|string|max:20',
            'pays' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:50',
        ]);

        Emetteur::create($request->all());

        return redirect()->route('emetteurs.index')->with('success', 'Émetteur créé avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Emetteur  $emetteur
     * @return \Illuminate\Http\Response
     */
    public function show(Emetteur $emetteur)
    {
        return view('emetteurs.show', compact('emetteur'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Emetteur  $emetteur
     * @return \Illuminate\Http\Response
     */
    public function edit(Emetteur $emetteur)
    {
        return view('emetteurs.edit', compact('emetteur'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Emetteur  $emetteur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Emetteur $emetteur)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'required|email|unique:emetteurs,email,' . $emetteur->id,
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'code_postal' => 'nullable|string|max:20',
            'pays' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:50',
        ]);

        $emetteur->update($request->all());

        return redirect()->route('emetteurs.index')->with('success', 'Émetteur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Emetteur  $emetteur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Emetteur $emetteur)
    {
        $emetteur->delete();

        return redirect()->route('emetteurs.index')->with('success', 'Émetteur supprimé avec succès.');
    }
}