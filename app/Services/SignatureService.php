<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class SignatureService
{
    /**
     * Générer une signature électronique avancée (AES) pour une facture
     */
    public function genererSignatureAES(string $documentPath, int $factureId): array
    {
        // Lire le contenu du document PDF
        $documentContent = Storage::disk('local')->get($documentPath);
        
        // Générer un hash SHA256 du document
        $hash = hash('sha256', $documentContent);
        
        // Créer un timestamp
        $timestamp = now()->toISOString();
        
        // Créer les métadonnées de signature
        $signatureData = [
            'facture_id' => $factureId,
            'hash' => $hash,
            'timestamp' => $timestamp,
            'signature_type' => 'AES',
            'certificate_valid_from' => now()->subDays(30)->toISOString(),
            'certificate_valid_until' => now()->addYears(2)->toISOString(),
        ];
        
        // Générer une signature numérique (simplifié pour cet exemple)
        $signature = $this->genererSignatureNumerique($signatureData);
        
        // Créer un QR code contenant la signature
        $qrCodePath = $this->creerQRCodeSignature($signatureData, $factureId);
        
        return [
            'signature' => $signature,
            'hash' => $hash,
            'timestamp' => $timestamp,
            'qr_code_path' => $qrCodePath,
            'signature_data' => $signatureData,
        ];
    }
    
    /**
     * Générer une signature numérique basée sur les données
     */
    private function genererSignatureNumerique(array $data): string
    {
        // Dans une implémentation réelle, cela utiliserait une clé privée pour signer
        // Pour cet exemple, nous utilisons un hash des données avec une clé secrète
        $secretKey = config('signature.aes_private_key', 'default_secret_key');
        $dataString = json_encode($data);
        
        return hash_hmac('sha256', $dataString, $secretKey);
    }
    
    /**
     * Créer un QR code contenant les informations de signature
     */
    private function creerQRCodeSignature(array $signatureData, int $factureId): string
    {
        $qrData = json_encode([
            'facture_id' => $factureId,
            'hash' => $signatureData['hash'],
            'timestamp' => $signatureData['timestamp'],
            'signature' => $signatureData['signature'],
        ]);
        
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new ImagickImageRenderer()
        );
        
        $writer = new Writer($renderer);
        $qrCodeContent = $writer->writeString($qrData);
        
        $fileName = "facture_{$factureId}_signature_qr.png";
        $filePath = "qrcodes/{$fileName}";
        
        Storage::put($filePath, $qrCodeContent);
        
        return $filePath;
    }
    
    /**
     * Vérifier la validité d'une signature
     */
    public function verifierSignature(int $factureId, string $originalDocumentPath): bool
    {
        // Récupérer les données de signature de la base de données
        $facture = \App\Models\Facture::find($factureId);
        if (!$facture || !$facture->signature_data) {
            return false;
        }
        
        // Lire le document original
        if (!Storage::exists($originalDocumentPath)) {
            return false;
        }
        
        $originalContent = Storage::get($originalDocumentPath);
        $originalHash = hash('sha256', $originalContent);
        
        // Comparer avec le hash stocké dans la signature
        $storedHash = $facture->signature_data['hash'] ?? '';
        
        return hash_equals($originalHash, $storedHash);
    }
    
    /**
     * Appliquer la signature à un document PDF
     */
    public function appliquerSignatureAuPDF(string $pdfPath, array $signatureInfo): string
    {
        // Dans une implémentation réelle, cela utiliserait une bibliothèque comme TCPDF ou Smalot\PdfParser
        // Pour cet exemple, nous ajoutons simplement les informations dans les métadonnées
        
        $outputPath = str_replace('.pdf', '_signed.pdf', $pdfPath);
        
        // Simuler l'application de la signature (dans la réalité, cela modifierait le fichier PDF)
        // On copie simplement le fichier pour cet exemple
        Storage::copy($pdfPath, $outputPath);
        
        // Ajouter les informations de signature aux métadonnées
        $factureId = $signatureInfo['facture_id'];
        $facture = \App\Models\Facture::find($factureId);
        if ($facture) {
            $facture->update([
                'signature_appliquee' => true,
                'signature_data' => $signatureInfo,
                'pdf_signe_path' => $outputPath,
            ]);
        }
        
        return $outputPath;
    }
}