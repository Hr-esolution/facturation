<?php

namespace App\Http\Controllers;

use App\Models\FactureParametre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FactureParametreController extends Controller
{
    /**
     * Afficher la liste des paramètres de facturation
     */
    public function index()
    {
        $parametres = FactureParametre::all();
        return view('parametres.index', compact('parametres'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('parametres.create');
    }

    /**
     * Stocker un nouveau paramètre
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cle' => 'required|string|unique:facture_parametres',
            'valeur' => 'required|string',
            'description' => 'nullable|string',
            'type' => 'required|in:text,number,boolean,select,json',
            'pays' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            FactureParametre::create($request->all());

            return redirect()->route('facture-parametres.index')
                ->with('success', 'Paramètre créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la création du paramètre: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Afficher un paramètre spécifique
     */
    public function show(FactureParametre $parametre)
    {
        return view('parametres.show', compact('parametre'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(FactureParametre $parametre)
    {
        return view('parametres.edit', compact('parametre'));
    }

    /**
     * Mettre à jour un paramètre
     */
    public function update(Request $request, FactureParametre $parametre)
    {
        $validator = Validator::make($request->all(), [
            'cle' => 'required|string|unique:facture_parametres,cle,' . $parametre->id,
            'valeur' => 'required|string',
            'description' => 'nullable|string',
            'type' => 'required|in:text,number,boolean,select,json',
            'pays' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $parametre->update($request->all());

            return redirect()->route('facture-parametres.index')
                ->with('success', 'Paramètre mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour du paramètre: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Supprimer un paramètre
     */
    public function destroy(FactureParametre $parametre)
    {
        try {
            $parametre->delete();
            return redirect()->route('facture-parametres.index')
                ->with('success', 'Paramètre supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression du paramètre: ' . $e->getMessage());
        }
    }

    /**
     * Obtenir les paramètres pour un pays spécifique
     */
    public function getByPays($pays)
    {
        $parametres = FactureParametre::where('pays', $pays)->get();
        return response()->json($parametres);
    }

    /**
     * Obtenir les paramètres par clé
     */
    public function getByCle($cle)
    {
        $parametre = FactureParametre::where('cle', $cle)->first();
        
        if (!$parametre) {
            return response()->json(['error' => 'Paramètre non trouvé'], 404);
        }
        
        return response()->json($parametre);
    }
}