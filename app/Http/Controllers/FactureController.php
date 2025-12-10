<?php

namespace App\Http\Controllers;

use App\Services\FactureService;
use App\Services\PDFService;
use App\Services\SignatureService;
use App\Services\EmailService;
use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FactureController extends Controller
{
    protected $factureService;
    protected $pdfService;
    protected $signatureService;
    protected $emailService;

    public function __construct(
        FactureService $factureService,
        PDFService $pdfService,
        SignatureService $signatureService,
        EmailService $emailService
    ) {
        $this->factureService = $factureService;
        $this->pdfService = $pdfService;
        $this->signatureService = $signatureService;
        $this->emailService = $emailService;
    }

    /**
     * Afficher la liste des factures
     */
    public function index()
    {
        $factures = Facture::with(['emetteur', 'client'])->paginate(15);
        return view('factures.index', compact('factures'));
    }

    /**
     * Afficher le formulaire de création d'une facture
     */
    public function create()
    {
        return view('factures.create');
    }

    /**
     * Stocker une nouvelle facture
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_facture' => 'required|unique:factures',
            'emetteur_id' => 'required|exists:emetteurs,id',
            'client_id' => 'required|exists:clients,id',
            'date_emission' => 'required|date',
            'date_echeance' => 'required|date|after_or_equal:date_emission',
            'produits' => 'required|array|min:1',
            'produits.*.designation' => 'required|string',
            'produits.*.quantite' => 'required|numeric|min:0.01',
            'produits.*.prix_unitaire' => 'required|numeric|min:0',
            'produits.*.taux_tva' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Créer la facture via le service
            $facture = $this->factureService->creerFacture($request->all());
            
            // Vérifier la conformité
            $isConforme = $this->factureService->verifierConformite($facture);
            
            if (!$isConforme) {
                return redirect()->back()
                    ->with('error', 'La facture créée ne respecte pas les normes requises pour le pays du client.')
                    ->withInput();
            }

            return redirect()->route('factures.show', $facture->id)
                ->with('success', 'Facture créée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de la facture: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Afficher une facture spécifique
     */
    public function show(Facture $facture)
    {
        $facture->load(['emetteur', 'client', 'produits']);
        return view('factures.show', compact('facture'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Facture $facture)
    {
        return view('factures.edit', compact('facture'));
    }

    /**
     * Mettre à jour une facture
     */
    public function update(Request $request, Facture $facture)
    {
        $validator = Validator::make($request->all(), [
            'numero_facture' => 'required|unique:factures,numero_facture,' . $facture->id,
            'date_emission' => 'required|date',
            'date_echeance' => 'required|date|after_or_equal:date_emission',
            'produits' => 'required|array|min:1',
            'produits.*.designation' => 'required|string',
            'produits.*.quantite' => 'required|numeric|min:0.01',
            'produits.*.prix_unitaire' => 'required|numeric|min:0',
            'produits.*.taux_tva' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $facture->update($request->all());
            
            // Recalculer les totaux
            $factureData = $facture->toArray();
            $factureData = $this->factureService->calculerTotaux($factureData);
            $facture->update([
                'total_ht' => $factureData['total_ht'],
                'total_tva' => $factureData['total_tva'],
                'total_ttc' => $factureData['total_ttc'],
            ]);

            return redirect()->route('factures.show', $facture->id)
                ->with('success', 'Facture mise à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour de la facture: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Supprimer une facture
     */
    public function destroy(Facture $facture)
    {
        try {
            $facture->delete();
            return redirect()->route('factures.index')
                ->with('success', 'Facture supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression de la facture: ' . $e->getMessage());
        }
    }

    /**
     * Générer un PDF de la facture
     */
    public function generatePDF(Facture $facture, Request $request)
    {
        try {
            $template = $request->get('template', 'standard');
            $langue = $request->get('langue', 'fr');
            
            // Préparer les données de la facture
            $factureData = $facture->toArray();
            $factureData['emetteur'] = $facture->emetteur->toArray();
            $factureData['client'] = $facture->client->toArray();
            
            // Générer le PDF
            $pdfPath = $this->pdfService->genererPDFFacture($factureData, $template);
            
            // Si une signature est demandée
            if ($request->get('with_signature')) {
                $signatureInfo = $this->signatureService->genererSignatureAES($pdfPath, $facture->id);
                $pdfPath = $this->signatureService->appliquerSignatureAuPDF($pdfPath, $signatureInfo);
            }
            
            // Retourner le PDF pour téléchargement
            $pdfContent = storage_path('app/' . $pdfPath);
            return response()->download($pdfContent, "facture_{$facture->numero_facture}.pdf");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la génération du PDF: ' . $e->getMessage());
        }
    }

    /**
     * Envoyer la facture par email
     */
    public function sendByEmail(Facture $facture, Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'pays' => 'required|string',
        ]);

        try {
            $factureData = $facture->toArray();
            $factureData['emetteur'] = $facture->emetteur->toArray();
            $factureData['client'] = $facture->client->toArray();
            
            $success = $this->emailService->envoyerFacture(
                $factureData,
                $request->email,
                $request->pays
            );

            if ($success) {
                return redirect()->back()
                    ->with('success', 'Facture envoyée avec succès par email.');
            } else {
                return redirect()->back()
                    ->with('error', 'Erreur lors de l\'envoi de la facture par email.');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'envoi de la facture: ' . $e->getMessage());
        }
    }
}