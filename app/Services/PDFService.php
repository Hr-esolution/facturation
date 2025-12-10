<?php

namespace App\Services;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFService
{
    /**
     * Générer un PDF de facture selon le template spécifié
     */
    public function genererPDFFacture(array $factureData, string $template = 'standard'): string
    {
        // Déterminer le template approprié selon le pays et les besoins
        $templatePath = $this->determinerTemplate($factureData, $template);
        
        // Générer le contenu HTML
        $html = View::make($templatePath, ['facture' => $factureData])->render();
        
        // Générer le PDF
        $pdf = Pdf::loadHTML($html);
        
        // Définir le nom du fichier
        $filename = "facture_{$factureData['numero_facture']}.pdf";
        $filePath = "invoices/{$filename}";
        
        // Sauvegarder le PDF
        Storage::put($filePath, $pdf->output());
        
        return $filePath;
    }
    
    /**
     * Déterminer le template approprié selon le pays et les besoins
     */
    private function determinerTemplate(array $factureData, string $template): string
    {
        $paysClient = $factureData['client']['pays'] ?? 'FR';
        $hasQRCode = $factureData['has_qr_code'] ?? false;
        $hasSignature = $factureData['has_signature'] ?? false;
        
        // Si c'est un pays qui nécessite un template spécifique
        switch ($paysClient) {
            case 'SA': // Arabie Saoudite - ZATCA
                if ($hasQRCode) {
                    return 'factures.templates.qr_invoice';
                }
                return 'factures.templates.compliant_sa';
                
            case 'MA': // Maroc
                return 'factures.templates.compliant_maroc';
                
            case 'EU': // Union Européenne
            case 'FR': // France
                return 'factures.templates.compliant_eu';
                
            case 'CA': // Canada
                return 'factures.templates.compliant_canada';
                
            case 'US': // USA
                return 'factures.templates.compliant_usa';
                
            default:
                // Si signature requise
                if ($hasSignature) {
                    return 'factures.templates.signature_aes';
                }
                
                // Template standard
                return "factures.templates.{$template}";
        }
    }
    
    /**
     * Générer un PDF avec des champs dynamiques selon le pays
     */
    public function genererPDFAvecChampsDynamiques(array $factureData): string
    {
        // Récupérer les champs requis pour ce pays
        $champsRequis = $this->getChampsRequisParPays($factureData['client']['pays'] ?? 'FR');
        
        // Fusionner les données avec les champs requis
        $factureData['champs_dynamiques'] = $champsRequis;
        
        return $this->genererPDFFacture($factureData, 'dynamic_fields');
    }
    
    /**
     * Obtenir les champs requis selon le pays
     */
    private function getChampsRequisParPays(string $pays): array
    {
        $champsParDefaut = [
            ['nom' => 'numero_facture', 'label' => 'Numéro de facture', 'type' => 'text', 'requis' => true],
            ['nom' => 'date_emission', 'label' => 'Date d\'émission', 'type' => 'date', 'requis' => true],
            ['nom' => 'date_echeance', 'label' => 'Date d\'échéance', 'type' => 'date', 'requis' => true],
            ['nom' => 'emetteur', 'label' => 'Émetteur', 'type' => 'section', 'requis' => true],
            ['nom' => 'client', 'label' => 'Client', 'type' => 'section', 'requis' => true],
            ['nom' => 'produits', 'label' => 'Produits/Services', 'type' => 'table', 'requis' => true],
            ['nom' => 'total_ht', 'label' => 'Total HT', 'type' => 'currency', 'requis' => true],
            ['nom' => 'total_tva', 'label' => 'Total TVA', 'type' => 'currency', 'requis' => true],
            ['nom' => 'total_ttc', 'label' => 'Total TTC', 'type' => 'currency', 'requis' => true],
        ];
        
        switch ($pays) {
            case 'MA': // Maroc
                return array_merge($champsParDefaut, [
                    ['nom' => 'client.ice', 'label' => 'ICE', 'type' => 'text', 'requis' => true],
                    ['nom' => 'client.if', 'label' => 'Identifiant Fiscal (IF)', 'type' => 'text', 'requis' => true],
                    ['nom' => 'client.rc', 'label' => 'Registre de Commerce (RC)', 'type' => 'text', 'requis' => true],
                    ['nom' => 'client.patente', 'label' => 'Patente', 'type' => 'text', 'requis' => true],
                    ['nom' => 'client.cnss', 'label' => 'CNSS', 'type' => 'text', 'requis' => false],
                    ['nom' => 'mode_paiement', 'label' => 'Mode de paiement', 'type' => 'select', 'requis' => true],
                ]);
                
            case 'EU': // Union Européenne
            case 'FR': // France
                return array_merge($champsParDefaut, [
                    ['nom' => 'client.numero_tva_intracommunautaire', 'label' => 'N° TVA Intracommunautaire', 'type' => 'text', 'requis' => true],
                    ['nom' => 'client.adresse_complete', 'label' => 'Adresse complète', 'type' => 'textarea', 'requis' => true],
                    ['nom' => 'mention_autoliquidation', 'label' => 'Mention Autoliquidation', 'type' => 'checkbox', 'requis' => false],
                    ['nom' => 'article_293b', 'label' => 'Article 293B', 'type' => 'checkbox', 'requis' => false],
                ]);
                
            case 'CA': // Canada
                return array_merge($champsParDefaut, [
                    ['nom' => 'client.numero_gst_hst_qst', 'label' => 'N° GST/HST/QST', 'type' => 'text', 'requis' => true],
                    ['nom' => 'client.numero_enregistrement', 'label' => 'N° d\'enregistrement', 'type' => 'text', 'requis' => true],
                    ['nom' => 'devise', 'label' => 'Devise', 'type' => 'select', 'options' => ['CAD' => 'CAD (requis)', 'USD' => 'USD (si contrat)'], 'requis' => true],
                ]);
                
            case 'US': // USA
                return array_merge($champsParDefaut, [
                    ['nom' => 'client.ein', 'label' => 'EIN', 'type' => 'text', 'requis' => true],
                    ['nom' => 'client.state_sales_tax', 'label' => 'State Sales Tax', 'type' => 'text', 'requis' => true],
                    ['nom' => 'client.zip_code', 'label' => 'ZIP Code', 'type' => 'text', 'requis' => true],
                    ['nom' => 'client.state_of_sale', 'label' => 'State of Sale', 'type' => 'text', 'requis' => true],
                ]);
                
            default:
                return $champsParDefaut;
        }
    }
    
    /**
     * Générer un PDF multilingue
     */
    public function genererPDFMultilingue(array $factureData, string $langue = 'fr'): string
    {
        // Définir la langue pour la localisation
        \App::setLocale($langue);
        
        // Générer le PDF avec les traductions appropriées
        $templatePath = $this->determinerTemplate($factureData, 'standard');
        
        // Charger les fichiers de traduction
        $translations = $this->chargerTraductions($langue);
        
        $html = View::make($templatePath, [
            'facture' => $factureData,
            'translations' => $translations
        ])->render();
        
        $pdf = Pdf::loadHTML($html);
        
        $filename = "facture_{$factureData['numero_facture']}_{$langue}.pdf";
        $filePath = "invoices/{$filename}";
        
        Storage::put($filePath, $pdf->output());
        
        return $filePath;
    }
    
    /**
     * Charger les traductions pour une langue spécifique
     */
    private function chargerTraductions(string $langue): array
    {
        $translationsPath = resource_path("lang/{$langue}/invoice.php");
        
        if (file_exists($translationsPath)) {
            return include $translationsPath;
        }
        
        // Retourner les traductions par défaut en français
        return include resource_path('lang/fr/invoice.php');
    }
}