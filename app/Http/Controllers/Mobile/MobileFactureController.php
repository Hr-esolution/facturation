<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Services\FactureService;
use App\Services\PDFService;
use App\Services\SignatureService;
use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MobileFactureController extends Controller
{
    protected $factureService;
    protected $pdfService;
    protected $signatureService;

    public function __construct(
        FactureService $factureService,
        PDFService $pdfService,
        SignatureService $signatureService
    ) {
        $this->factureService = $factureService;
        $this->pdfService = $pdfService;
        $this->signatureService = $signatureService;
    }

    /**
     * Obtenir la liste des factures pour l'application mobile
     */
    public function index(Request $request)
    {
        $query = Facture::with(['emetteur', 'client']);

        // Filtres pour l'application mobile
        if ($request->has('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->has('date_debut')) {
            $query->where('date_emission', '>=', $request->date_debut);
        }

        if ($request->has('date_fin')) {
            $query->where('date_emission', '<=', $request->date_fin);
        }

        $factures = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $factures
        ]);
    }

    /**
     * Obtenir une facture spécifique
     */
    public function show($id)
    {
        $facture = Facture::with(['emetteur', 'client', 'produits'])->find($id);

        if (!$facture) {
            return response()->json([
                'success' => false,
                'message' => 'Facture non trouvée'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $facture
        ]);
    }

    /**
     * Créer une nouvelle facture via l'application mobile
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
            return response()->json([
                'success' => false,
                'message' => 'Validation échouée',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $facture = $this->factureService->creerFacture($request->all());
            
            // Vérifier la conformité
            $isConforme = $this->factureService->verifierConformite($facture);
            
            if (!$isConforme) {
                return response()->json([
                    'success' => false,
                    'message' => 'La facture créée ne respecte pas les normes requises pour le pays du client.'
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => 'Facture créée avec succès',
                'data' => $facture
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la facture: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour une facture
     */
    public function update(Request $request, $id)
    {
        $facture = Facture::find($id);
        
        if (!$facture) {
            return response()->json([
                'success' => false,
                'message' => 'Facture non trouvée'
            ], 404);
        }

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
            return response()->json([
                'success' => false,
                'message' => 'Validation échouée',
                'errors' => $validator->errors()
            ], 422);
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

            return response()->json([
                'success' => true,
                'message' => 'Facture mise à jour avec succès',
                'data' => $facture
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de la facture: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer une facture
     */
    public function destroy($id)
    {
        $facture = Facture::find($id);
        
        if (!$facture) {
            return response()->json([
                'success' => false,
                'message' => 'Facture non trouvée'
            ], 404);
        }

        try {
            $facture->delete();
            return response()->json([
                'success' => true,
                'message' => 'Facture supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la facture: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Générer un PDF de facture pour téléchargement mobile
     */
    public function generatePDF($id, Request $request)
    {
        $facture = Facture::with(['emetteur', 'client'])->find($id);

        if (!$facture) {
            return response()->json([
                'success' => false,
                'message' => 'Facture non trouvée'
            ], 404);
        }

        try {
            $template = $request->get('template', 'standard');
            $langue = $request->get('langue', 'fr');
            
            $factureData = $facture->toArray();
            $factureData['emetteur'] = $facture->emetteur->toArray();
            $factureData['client'] = $facture->client->toArray();
            
            $pdfPath = $this->pdfService->genererPDFFacture($factureData, $template);
            
            // Si une signature est demandée
            if ($request->get('with_signature')) {
                $signatureInfo = $this->signatureService->genererSignatureAES($pdfPath, $facture->id);
                $pdfPath = $this->signatureService->appliquerSignatureAuPDF($pdfPath, $signatureInfo);
            }
            
            // Retourner l'URL du PDF pour téléchargement mobile
            $pdfUrl = asset('storage/' . $pdfPath);
            
            return response()->json([
                'success' => true,
                'pdf_url' => $pdfUrl,
                'filename' => "facture_{$facture->numero_facture}.pdf"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la génération du PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rechercher des factures
     */
    public function search(Request $request)
    {
        $query = Facture::with(['emetteur', 'client']);

        if ($request->has('q')) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('numero_facture', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('client', function($clientQuery) use ($searchTerm) {
                      $clientQuery->where('nom', 'LIKE', "%{$searchTerm}%");
                  })
                  ->orWhereHas('emetteur', function($emetteurQuery) use ($searchTerm) {
                      $emetteurQuery->where('nom', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        $factures = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $factures
        ]);
    }
}