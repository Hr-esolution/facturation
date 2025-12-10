<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FactureChamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FactureChampController extends Controller
{
    /**
     * Afficher la liste des champs
     */
    public function index()
    {
        $champs = FactureChamp::all();
        return view('admin.champs.index', compact('champs'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin.champs.create');
    }

    /**
     * Stocker un nouveau champ
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|unique:facture_champs',
            'label' => 'required|string',
            'type' => 'required|in:text,number,select,date,textarea,checkbox,radio',
            'pays' => 'required|string',
            'est_requis' => 'boolean',
            'valeur_defaut' => 'nullable|string',
            'options' => 'nullable|json',
            'ordre_affichage' => 'nullable|integer',
            'groupe' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $champ = FactureChamp::create($request->all());

            return redirect()->route('admin.facture-champs.index')
                ->with('success', 'Champ créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la création du champ: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Afficher un champ spécifique
     */
    public function show(FactureChamp $champ)
    {
        return view('admin.champs.show', compact('champ'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(FactureChamp $champ)
    {
        return view('admin.champs.edit', compact('champ'));
    }

    /**
     * Mettre à jour un champ
     */
    public function update(Request $request, FactureChamp $champ)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|unique:facture_champs,nom,' . $champ->id,
            'label' => 'required|string',
            'type' => 'required|in:text,number,select,date,textarea,checkbox,radio',
            'pays' => 'required|string',
            'est_requis' => 'boolean',
            'valeur_defaut' => 'nullable|string',
            'options' => 'nullable|json',
            'ordre_affichage' => 'nullable|integer',
            'groupe' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $champ->update($request->all());

            return redirect()->route('admin.facture-champs.index')
                ->with('success', 'Champ mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour du champ: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Supprimer un champ
     */
    public function destroy(FactureChamp $champ)
    {
        try {
            $champ->delete();
            return redirect()->route('admin.facture-champs.index')
                ->with('success', 'Champ supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression du champ: ' . $e->getMessage());
        }
    }

    /**
     * Obtenir les champs pour un pays spécifique
     */
    public function getByPays($pays)
    {
        $champs = FactureChamp::where('pays', $pays)
            ->orderBy('ordre_affichage')
            ->get();
        
        return response()->json($champs);
    }

    /**
     * Obtenir les champs requis pour un pays spécifique
     */
    public function getRequiredByPays($pays)
    {
        $champs = FactureChamp::where('pays', $pays)
            ->where('est_requis', true)
            ->orderBy('ordre_affichage')
            ->get();
        
        return response()->json($champs);
    }

    /**
     * Mettre à jour l'ordre d'affichage des champs
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'champs' => 'required|array',
            'champs.*.id' => 'required|exists:facture_champs,id',
            'champs.*.ordre' => 'required|integer',
        ]);

        foreach ($request->champs as $champData) {
            FactureChamp::where('id', $champData['id'])->update([
                'ordre_affichage' => $champData['ordre']
            ]);
        }

        return response()->json(['message' => 'Ordre des champs mis à jour avec succès']);
    }
}