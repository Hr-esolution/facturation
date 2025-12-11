<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FactureTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FactureTemplateController extends Controller
{
    /**
     * Afficher la liste des templates
     */
    public function index()
    {
        $templates = FactureTemplate::all();
        return view('admin.facture-templates.index', compact('templates'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin.facture-templates.create');
    }

    /**
     * Stocker un nouveau template
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|unique:facture_templates',
            'titre' => 'required|string',
            'description' => 'nullable|string',
            'contenu' => 'required|string',
            'pays_concerne' => 'nullable|string',
            'est_actif' => 'boolean',
            'est_par_defaut' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $template = FactureTemplate::create($request->all());

            return redirect()->route('admin.facture-templates.index')
                ->with('success', 'Template créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la création du template: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Afficher un template spécifique
     */
    public function show(FactureTemplate $template)
    {
        return view('admin.facture-templates.show', compact('template'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(FactureTemplate $template)
    {
        return view('admin.facture-templates.edit', compact('template'));
    }

    /**
     * Mettre à jour un template
     */
    public function update(Request $request, FactureTemplate $template)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|unique:facture_templates,nom,' . $template->id,
            'titre' => 'required|string',
            'description' => 'nullable|string',
            'contenu' => 'required|string',
            'pays_concerne' => 'nullable|string',
            'est_actif' => 'boolean',
            'est_par_defaut' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $template->update($request->all());

            return redirect()->route('admin.facture-templates.index')
                ->with('success', 'Template mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour du template: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Supprimer un template
     */
    public function destroy(FactureTemplate $template)
    {
        try {
            $template->delete();
            return redirect()->route('admin.facture-templates.index')
                ->with('success', 'Template supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression du template: ' . $e->getMessage());
        }
    }

    /**
     * Activer/désactiver un template
     */
    public function toggleStatus(FactureTemplate $template)
    {
        $template->update(['est_actif' => !$template->est_actif]);
        
        $status = $template->est_actif ? 'activé' : 'désactivé';
        return redirect()->back()->with('success', "Template {$status} avec succès.");
    }

    /**
     * Définir un template comme par défaut
     */
    public function setAsDefault(FactureTemplate $template)
    {
        // Désactiver tous les autres templates par défaut
        FactureTemplate::where('est_par_defaut', true)->update(['est_par_defaut' => false]);
        
        // Activer ce template comme par défaut
        $template->update(['est_par_defaut' => true]);
        
        return redirect()->back()->with('success', 'Template défini comme par défaut avec succès.');
    }
}