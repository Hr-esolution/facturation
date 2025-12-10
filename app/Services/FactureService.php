<?php

namespace App\Services;

use App\Models\Facture;
use App\Models\Client;
use App\Models\Emetteur;
use Illuminate\Support\Facades\Validator;

class FactureService
{
    /**
     * Valider et créer une facture selon les normes du pays
     */
    public function creerFacture(array $data): Facture
    {
        // Déterminer les règles de validation selon le pays
        $reglesValidation = $this->getReglesValidationParPays($data['pays_client'] ?? 'FR');
        
        $validator = Validator::make($data, $reglesValidation);
        
        if ($validator->fails()) {
            throw new \Exception('Validation failed: ' . $validator->errors()->first());
        }
        
        // Calculer les totaux
        $data = $this->calculerTotaux($data);
        
        return Facture::create($data);
    }
    
    /**
     * Obtenir les règles de validation selon le pays
     */
    private function getReglesValidationParPays(string $pays): array
    {
        $reglesBase = [
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
        ];
        
        switch ($pays) {
            case 'MA': // Maroc
                return array_merge($reglesBase, [
                    'client.ice' => 'required|string',
                    'client.if' => 'required|string',
                    'client.rc' => 'required|string',
                    'client.patente' => 'required|string',
                    'mode_paiement' => 'required|string',
                ]);
                
            case 'EU': // Union Européenne
            case 'FR': // France
                return array_merge($reglesBase, [
                    'client.numero_tva_intracommunautaire' => 'required|string',
                    'client.adresse_complete' => 'required|string',
                ]);
                
            case 'CA': // Canada
                return array_merge($reglesBase, [
                    'client.numero_gst_hst_qst' => 'required|string',
                    'client.numero_enregistrement' => 'required|string',
                ]);
                
            case 'US': // USA
                return array_merge($reglesBase, [
                    'client.ein' => 'required|string',
                    'client.state_sales_tax' => 'required|string',
                    'client.zip_code' => 'required|string',
                ]);
                
            default:
                return $reglesBase;
        }
    }
    
    /**
     * Calculer les totaux HT, TVA et TTC
     */
    private function calculerTotaux(array $data): array
    {
        $total_ht = 0;
        $total_tva = 0;
        
        foreach ($data['produits'] as $produit) {
            $montant_ht = $produit['quantite'] * $produit['prix_unitaire'];
            $montant_tva = $montant_ht * ($produit['taux_tva'] / 100);
            
            $total_ht += $montant_ht;
            $total_tva += $montant_tva;
        }
        
        $data['total_ht'] = $total_ht;
        $data['total_tva'] = $total_tva;
        $data['total_ttc'] = $total_ht + $total_tva;
        
        return $data;
    }
    
    /**
     * Vérifier la conformité selon les normes internationales
     */
    public function verifierConformite(Facture $facture): bool
    {
        // Vérification des éléments obligatoires internationaux
        $elementsRequis = [
            'numero_facture',
            'emetteur_id',
            'client_id',
            'produits',
            'total_ht',
            'total_tva',
            'total_ttc',
            'date_emission',
        ];
        
        foreach ($elementsRequis as $element) {
            if (empty($facture->$element)) {
                return false;
            }
        }
        
        // Vérifier les éléments spécifiques au pays du client
        $client = Client::find($facture->client_id);
        if (!$client) {
            return false;
        }
        
        switch ($client->pays ?? 'FR') {
            case 'MA':
                return !empty($client->ice) && !empty($client->if) && !empty($client->rc) && !empty($client->patente);
                
            case 'EU':
            case 'FR':
                return !empty($client->numero_tva_intracommunautaire);
                
            case 'CA':
                return !empty($client->numero_gst_hst_qst) && !empty($client->numero_enregistrement);
                
            case 'US':
                return !empty($client->ein) && !empty($client->state_sales_tax);
        }
        
        return true;
    }
}