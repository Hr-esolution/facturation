<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QRCodeService
{
    /**
     * Générer un QR code fiscal selon les normes du pays (ZATCA, Maroc, etc.)
     */
    public function genererQRCodeFiscal(array $factureData, string $pays): string
    {
        switch ($pays) {
            case 'SA': // Arabie Saoudite - ZATCA
                return $this->genererQRCodeZATCA($factureData);
                
            case 'MA': // Maroc - potentiellement requis à l'avenir
                return $this->genererQRCodeMaroc($factureData);
                
            default:
                return $this->genererQRCodeStandard($factureData);
        }
    }
    
    /**
     * Générer un QR code selon la norme ZATCA (Arabie Saoudite)
     * Format : seller_name|vat_number|timestamp|total_amount|vat_amount
     */
    private function genererQRCodeZATCA(array $factureData): string
    {
        $emetteur = $factureData['emetteur'] ?? [];
        $totalHT = $factureData['total_ht'] ?? 0;
        $totalTVA = $factureData['total_tva'] ?? 0;
        $totalTTC = $factureData['total_ttc'] ?? 0;
        
        // Format ZATCA: seller_name|vat_number|timestamp|total_amount|vat_amount
        $qrData = implode('|', [
            $emetteur['nom'] ?? '',           // Nom du vendeur
            $emetteur['numero_tva'] ?? '',    // Numéro TVA
            now()->toISOString(),             // Timestamp
            number_format($totalTTC, 2, '.', ''), // Montant total TTC
            number_format($totalTVA, 2, '.', '')  // Montant TVA
        ]);
        
        return $this->creerQRCodeSVG($qrData, "zatca_{$factureData['id']}.svg");
    }
    
    /**
     * Générer un QR code pour le Maroc (format futur potentiel)
     */
    private function genererQRCodeMaroc(array $factureData): string
    {
        $emetteur = $factureData['emetteur'] ?? [];
        $client = $factureData['client'] ?? [];
        
        $qrData = json_encode([
            'facture_numero' => $factureData['numero_facture'] ?? '',
            'emetteur_ice' => $emetteur['ice'] ?? '',
            'client_ice' => $client['ice'] ?? '',
            'date_emission' => $factureData['date_emission'] ?? '',
            'total_ttc' => $factureData['total_ttc'] ?? 0,
            'verification_url' => config('invoflex.maroc_verification_url', 'https://verification.example.com')
        ]);
        
        return $this->creerQRCodeSVG($qrData, "maroc_{$factureData['id']}.svg");
    }
    
    /**
     * Générer un QR code standard
     */
    private function genererQRCodeStandard(array $factureData): string
    {
        $qrData = json_encode([
            'facture_id' => $factureData['id'] ?? '',
            'numero_facture' => $factureData['numero_facture'] ?? '',
            'date_emission' => $factureData['date_emission'] ?? '',
            'total_ttc' => $factureData['total_ttc'] ?? 0,
            'verification_url' => url("/api/factures/{$factureData['id']}/verify")
        ]);
        
        return $this->creerQRCodeSVG($qrData, "standard_{$factureData['id']}.svg");
    }
    
    /**
     * Créer un QR code SVG
     */
    private function creerQRCodeSVG(string $data, string $filename): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        
        $writer = new Writer($renderer);
        $qrCodeContent = $writer->writeString($data);
        
        $filePath = "qrcodes/{$filename}";
        Storage::put($filePath, $qrCodeContent);
        
        return $filePath;
    }
    
    /**
     * Générer un QR code contenant la signature électronique
     */
    public function genererQRCodeSignature(array $signatureData): string
    {
        $qrData = json_encode([
            'facture_id' => $signatureData['facture_id'],
            'hash' => $signatureData['hash'],
            'timestamp' => $signatureData['timestamp'],
            'signature' => $signatureData['signature'],
            'signature_type' => $signatureData['signature_type'],
        ]);
        
        return $this->creerQRCodeSVG($qrData, "signature_{$signatureData['facture_id']}.svg");
    }
    
    /**
     * Vérifier la validité d'un QR code
     */
    public function verifierQRCode(string $qrCodePath, string $pays = 'standard'): bool
    {
        if (!Storage::exists($qrCodePath)) {
            return false;
        }
        
        // Lire le contenu du QR code
        $qrContent = Storage::get($qrCodePath);
        
        // Dans une implémentation réelle, on décoderait le QR code
        // Pour cet exemple, on suppose que le contenu est déjà décodé
        $decodedData = $this->decoderQRCode($qrContent);
        
        if (!$decodedData) {
            return false;
        }
        
        // Selon le pays, effectuer la vérification appropriée
        switch ($pays) {
            case 'SA': // ZATCA
                return $this->verifierDonneesZATCA($decodedData);
                
            case 'MA': // Maroc
                return $this->verifierDonneesMaroc($decodedData);
                
            default:
                return $this->verifierDonneesStandard($decodedData);
        }
    }
    
    /**
     * Décoder le contenu d'un QR code
     */
    private function decoderQRCode(string $qrContent)
    {
        // Dans une implémentation réelle, on utiliserait une bibliothèque pour lire le QR code
        // Pour cet exemple, on suppose que le contenu est déjà sous forme JSON
        $data = json_decode($qrContent, true);
        
        if (json_last_error() === JSON_ERROR_NONE) {
            return $data;
        }
        
        // Si ce n'est pas JSON, peut-être est-ce au format ZATCA (séparé par |)
        $parts = explode('|', $qrContent);
        if (count($parts) === 5) { // Format ZATCA
            return [
                'seller_name' => $parts[0],
                'vat_number' => $parts[1],
                'timestamp' => $parts[2],
                'total_amount' => $parts[3],
                'vat_amount' => $parts[4]
            ];
        }
        
        return null;
    }
    
    /**
     * Vérifier les données ZATCA
     */
    private function verifierDonneesZATCA(array $donnees): bool
    {
        // Vérifier que toutes les données ZATCA sont présentes
        $champsRequis = ['seller_name', 'vat_number', 'timestamp', 'total_amount', 'vat_amount'];
        
        foreach ($champsRequis as $champ) {
            if (empty($donnees[$champ])) {
                return false;
            }
        }
        
        // Vérifier que le timestamp n'est pas trop ancien
        $timestamp = \DateTime::createFromFormat('Y-m-d\\TH:i:s\\.uP', $donnees['timestamp']);
        if (!$timestamp || $timestamp > now()->addHours(1) || $timestamp < now()->subDays(30)) {
            return false;
        }
        
        // Vérifier que les montants sont numériques
        if (!is_numeric($donnees['total_amount']) || !is_numeric($donnees['vat_amount'])) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Vérifier les données Maroc
     */
    private function verifierDonneesMaroc(array $donnees): bool
    {
        $champsRequis = ['facture_numero', 'emetteur_ice', 'date_emission', 'total_ttc'];
        
        foreach ($champsRequis as $champ) {
            if (empty($donnees[$champ])) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Vérifier les données standard
     */
    private function verifierDonneesStandard(array $donnees): bool
    {
        $champsRequis = ['facture_id', 'numero_facture', 'date_emission'];
        
        foreach ($champsRequis as $champ) {
            if (empty($donnees[$champ])) {
                return false;
            }
        }
        
        return true;
    }
}