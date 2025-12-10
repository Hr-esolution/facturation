<?php

namespace App\Services;

use App\Mail\FactureEnvoyee;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Envoyer une facture par email avec les options appropriées selon le pays
     */
    public function envoyerFacture(array $factureData, string $emailDestinataire, string $pays = 'FR'): bool
    {
        try {
            // Déterminer les options d'email selon le pays
            $optionsEmail = $this->getOptionsEmailParPays($pays);
            
            // Préparer les données pour l'email
            $donneesEmail = [
                'facture' => $factureData,
                'pays' => $pays,
                'options' => $optionsEmail,
            ];
            
            // Envoyer l'email
            Mail::to($emailDestinataire)->send(new FactureEnvoyee($donneesEmail));
            
            Log::info("Email de facture envoyé avec succès à {$emailDestinataire}", [
                'facture_id' => $factureData['id'] ?? null,
                'pays' => $pays,
                'destinataire' => $emailDestinataire
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de l'email de facture", [
                'erreur' => $e->getMessage(),
                'destinataire' => $emailDestinataire,
                'facture_id' => $factureData['id'] ?? null
            ]);
            
            return false;
        }
    }
    
    /**
     * Obtenir les options d'email selon le pays
     */
    private function getOptionsEmailParPays(string $pays): array
    {
        $options = [
            'langue' => $this->determinerLangueParPays($pays),
            'mentions_legales' => $this->getMentionsLegalesParPays($pays),
            'pj_requis' => [],
            'delai_relance' => 30, // jours
        ];
        
        switch ($pays) {
            case 'MA': // Maroc
                $options['pj_requis'][] = 'attestation_fiscale';
                $options['pj_requis'][] = 'facture_pdf';
                $options['mentions_legales'][] = 'Facture conforme aux dispositions fiscales marocaines';
                break;
                
            case 'EU': // Union Européenne
            case 'FR': // France
                $options['pj_requis'][] = 'facture_pdf';
                $options['mentions_legales'][] = 'Facture conforme au règlement européen sur la TVA';
                $options['mentions_legales'][] = 'Exercice d\'autoliquidation de la TVA si applicable';
                $options['delai_relance'] = 45;
                break;
                
            case 'CA': // Canada
                $options['pj_requis'][] = 'facture_pdf';
                $options['mentions_legales'][] = 'Facture conforme aux exigences fiscales canadiennes';
                $options['langue'] = 'fr_CA'; // ou 'en_CA' selon la province
                break;
                
            case 'US': // USA
                $options['pj_requis'][] = 'facture_pdf';
                $options['mentions_legales'][] = 'Facture conforme aux réglementations fiscales américaines';
                $options['delai_relance'] = 30;
                break;
                
            default:
                $options['pj_requis'][] = 'facture_pdf';
                break;
        }
        
        return $options;
    }
    
    /**
     * Déterminer la langue par défaut selon le pays
     */
    private function determinerLangueParPays(string $pays): string
    {
        $langues = [
            'MA' => 'ar', // ou 'fr'
            'EU' => 'fr',
            'FR' => 'fr',
            'CA' => 'fr_CA', // ou 'en_CA'
            'US' => 'en',
            'GB' => 'en',
            'DE' => 'de',
            'IT' => 'it',
            'ES' => 'es',
        ];
        
        return $langues[$pays] ?? 'fr';
    }
    
    /**
     * Obtenir les mentions légales selon le pays
     */
    private function getMentionsLegalesParPays(string $pays): array
    {
        $mentions = [
            'generales' => [
                'Document officiel de facturation',
                'Facture émise électroniquement',
                'Fait foi de créance',
            ]
        ];
        
        switch ($pays) {
            case 'MA': // Maroc
                $mentions['specifiques'] = [
                    'Conforme aux dispositions du CGI marocain',
                    'Soumis aux obligations fiscales prévues par la législation marocaine',
                    'Doit être conservé pendant 5 ans',
                ];
                break;
                
            case 'EU': // Union Européenne
            case 'FR': // France
                $mentions['specifiques'] = [
                    'Conforme au règlement européen sur la TVA',
                    'Mention d\'autoliquidation si applicable',
                    'Doit être conservé pendant 10 ans',
                    'Mention des pénalités en cas de retard de paiement',
                ];
                break;
                
            case 'CA': // Canada
                $mentions['specifiques'] = [
                    'Conforme aux exigences de l\'Agence du revenu du Canada',
                    'Soumis aux lois fiscales canadiennes',
                ];
                break;
                
            case 'US': // USA
                $mentions['specifiques'] = [
                    'Conforme aux exigences fiscales américaines',
                    'Soumis aux lois fiscales fédérales et étatiques',
                ];
                break;
                
            default:
                $mentions['specifiques'] = [
                    'Conforme aux dispositions légales en vigueur',
                ];
                break;
        }
        
        return array_merge($mentions['generales'], $mentions['specifiques'] ?? []);
    }
    
    /**
     * Envoyer une relance de paiement
     */
    public function envoyerRelancePaiement(array $factureData, string $emailDestinataire): bool
    {
        try {
            $donneesRelance = [
                'facture' => $factureData,
                'type' => 'relance',
                'delai_depasse' => $this->calculerDelaiDepasse($factureData['date_echeance']),
            ];
            
            $sujet = "Relance de paiement - Facture {$factureData['numero_facture']}";
            
            Mail::to($emailDestinataire)->send(new \App\Mail\RelancePaiement($donneesRelance, $sujet));
            
            Log::info("Email de relance envoyé avec succès", [
                'facture_id' => $factureData['id'] ?? null,
                'destinataire' => $emailDestinataire
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de l'email de relance", [
                'erreur' => $e->getMessage(),
                'destinataire' => $emailDestinataire,
                'facture_id' => $factureData['id'] ?? null
            ]);
            
            return false;
        }
    }
    
    /**
     * Calculer le délai de retard de paiement
     */
    private function calculerDelaiDepasse(string $dateEcheance): int
    {
        $dateEcheanceObj = \Carbon\Carbon::parse($dateEcheance);
        $now = \Carbon\Carbon::now();
        
        return max(0, $now->diffInDays($dateEcheanceObj));
    }
    
    /**
     * Envoyer un accusé de réception de facture (pour les systèmes de notification automatique)
     */
    public function envoyerAccuséRéception(array $factureData, string $emailDestinataire, string $organismeFiscal): bool
    {
        try {
            $donneesAccuse = [
                'facture' => $factureData,
                'organisme_fiscal' => $organismeFiscal,
                'timestamp' => now()->toISOString(),
                'statut' => 'reçue',
            ];
            
            $sujet = "Accusé de réception - Facture {$factureData['numero_facture']} ({$organismeFiscal})";
            
            Mail::to($emailDestinataire)->send(new \App\Mail\AccuseReceptionFacture($donneesAccuse, $sujet));
            
            Log::info("Accusé de réception envoyé", [
                'facture_id' => $factureData['id'] ?? null,
                'organisme_fiscal' => $organismeFiscal,
                'destinataire' => $emailDestinataire
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de l'accusé de réception", [
                'erreur' => $e->getMessage(),
                'destinataire' => $emailDestinataire,
                'facture_id' => $factureData['id'] ?? null
            ]);
            
            return false;
        }
    }
}