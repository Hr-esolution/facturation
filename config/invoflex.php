<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Normes internationales de facturation
    |--------------------------------------------------------------------------
    |
    | Configuration des normes de facturation selon les pays
    | Ces règles sont utilisées par le FactureService pour valider les factures
    |
    */
    
    'normes_facturation' => [
        // Normes internationales communes à toutes les factures
        'communes' => [
            'champs_obligatoires' => [
                'numero_facture',
                'emetteur_id',
                'client_id',
                'produits',
                'date_emission',
                'total_ht',
                'total_tva',
                'total_ttc',
                'conditions_paiement',
            ],
            'formats' => [
                'numero_facture' => 'unique_timestamped',
                'date_format' => 'Y-m-d',
                'devise' => 'ISO_4217',
            ],
        ],
        
        // Normes spécifiques par pays
        'pays' => [
            'MA' => [ // Maroc
                'champs_obligatoires' => [
                    'client.ice',
                    'client.if',
                    'client.rc',
                    'client.patente',
                    'mode_paiement',
                    'reference_client',
                ],
                'champs_facultatifs' => [
                    'client.cnss',
                ],
                'formats' => [
                    'numero_facture' => 'MA-{année}-{séquence}',
                    'ice_format' => '10 chiffres',
                    'if_format' => '8 chiffres',
                ],
                'mentions_legales' => [
                    'Soumis aux dispositions du CGI marocain',
                    'Doit être conservé pendant 5 ans',
                ],
                'verification_url' => env('MAROC_VERIFICATION_URL', 'https://verification.impots.gov.ma'),
            ],
            
            'EU' => [ // Union Européenne
                'champs_obligatoires' => [
                    'client.numero_tva_intracommunautaire',
                    'client.adresse_complete',
                ],
                'champs_facultatifs' => [
                    'mention_autoliquidation',
                    'article_293B',
                ],
                'formats' => [
                    'numero_tva_format' => 'EU_VAT_FORMAT',
                    'affichage_tva' => 'HT_TTC',
                ],
                'mentions_legales' => [
                    'Conforme au règlement européen sur la TVA',
                    'Exercice d\'autoliquidation de la TVA si applicable',
                ],
            ],
            
            'FR' => [ // France (sous-ensemble de l'UE avec des spécificités)
                'champs_obligatoires' => [
                    'client.numero_tva_intracommunautaire',
                    'client.adresse_complete',
                    'client.numero_rcs',
                    'client.numero_siren',
                    'client.numero_siret',
                    'client.code_ape',
                ],
                'champs_facultatifs' => [
                    'mentions_penalites_retard',
                    'eco_contributions',
                ],
                'formats' => [
                    'numero_tva_format' => 'FR_VAT_FORMAT',
                    'numero_siren_format' => '9 chiffres',
                    'numero_siret_format' => '14 chiffres',
                ],
                'mentions_legales' => [
                    'Conforme au CGI français',
                    'Mentions des pénalités en cas de retard de paiement',
                ],
            ],
            
            'CA' => [ // Canada
                'champs_obligatoires' => [
                    'client.numero_gst_hst_qst',
                    'client.numero_enregistrement',
                ],
                'champs_facultatifs' => [
                    'devise_facture',
                ],
                'formats' => [
                    'devise_obligatoire' => 'CAD',
                    'numero_format' => 'CANADA_REGISTRATION_FORMAT',
                ],
                'mentions_legales' => [
                    'Conforme aux exigences de l\'Agence du revenu du Canada',
                ],
            ],
            
            'US' => [ // États-Unis
                'champs_obligatoires' => [
                    'client.ein',
                    'client.state_sales_tax',
                    'client.zip_code',
                    'client.state_of_sale',
                ],
                'champs_facultatifs' => [],
                'formats' => [
                    'ein_format' => 'XX-XXXXXXX',
                    'zip_code_format' => 'XXXXX ou XXXXX-XXXX',
                ],
                'mentions_legales' => [
                    'Conforme aux réglementations fiscales américaines',
                ],
            ],
            
            'SA' => [ // Arabie Saoudite - ZATCA
                'champs_obligatoires' => [
                    'qr_code_fiscal',
                ],
                'champs_facultatifs' => [],
                'formats' => [
                    'qr_format' => 'ZATCA_FORMAT',
                    'format_zatca' => 'seller_name|vat_number|timestamp|total_amount|vat_amount',
                ],
                'mentions_legales' => [
                    'Conforme aux exigences ZATCA saoudiennes',
                ],
            ],
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Configuration de la signature électronique
    |--------------------------------------------------------------------------
    */
    
    'signature' => [
        'type_defaut' => 'AES', // Advanced Electronic Signature
        'types_supportes' => [
            'AES', // Advanced Electronic Signature
            'QES', // Qualified Electronic Signature
        ],
        'certificat_path' => storage_path('app/certs/signature_cert.pem'),
        'private_key_path' => storage_path('app/certs/signature_key.pem'),
        'duree_validite' => 365, // jours
        'algorithmes_supportes' => [
            'sha256',
            'sha512',
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Configuration des templates PDF
    |--------------------------------------------------------------------------
    */
    
    'pdf' => [
        'templates' => [
            'standard' => 'factures.templates.standard',
            'pro' => 'factures.templates.pro',
            'compliant_eu' => 'factures.templates.compliant_eu',
            'compliant_maroc' => 'factures.templates.compliant_maroc',
            'compliant_usa' => 'factures.templates.compliant_usa',
            'compliant_canada' => 'factures.templates.compliant_canada',
            'qr_invoice' => 'factures.templates.qr_invoice',
            'signature_aes' => 'factures.templates.signature_aes',
        ],
        'formats_supportes' => [
            'A4',
            'A3',
            'Letter',
        ],
        'langues_supportees' => [
            'fr',
            'en',
            'ar',
            'es',
            'de',
            'it',
        ],
        'polices_supportees' => [
            'dejavu',
            'times',
            'helvetica',
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Configuration des services fiscaux par pays
    |--------------------------------------------------------------------------
    */
    
    'services_fiscaux' => [
        'maroc' => [
            'api_url' => env('MAROC_API_URL', 'https://api.impots.gov.ma'),
            'verification_endpoint' => '/verification/facture',
            'notification_endpoint' => '/notifications/factures',
        ],
        'zatca' => [ // Arabie Saoudite
            'api_url' => env('ZATCA_API_URL', 'https://gw-apic-gov.gazt.gov.sa'),
            'verification_endpoint' => '/invoices/validation/invoice',
            'compliance_endpoint' => '/compliance/invoices',
        ],
        'ue' => [
            'api_url' => env('UE_API_URL', 'https://ec.europa.eu/taxation_customs/vies'),
            'verification_endpoint' => '/services/checkVatService',
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Configuration des devises et conversions
    |--------------------------------------------------------------------------
    */
    
    'devises' => [
        'par_defaut' => 'EUR',
        'supportees' => [
            'EUR', 'USD', 'GBP', 'CAD', 'AUD', 'JPY', 'CNY', 'MAD', 'SAR',
        ],
        'services_conversion' => [
            'fixer_api_key' => env('FIXER_API_KEY'),
            'openexchangerates_api_key' => env('OPENEXCHANGERATES_API_KEY'),
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Configuration des langues et localisation
    |--------------------------------------------------------------------------
    */
    
    'localisation' => [
        'langues_disponibles' => [
            'fr' => 'Français',
            'en' => 'English', 
            'ar' => 'العربية',
            'es' => 'Español',
            'de' => 'Deutsch',
            'it' => 'Italiano',
        ],
        'pays_disponibles' => [
            'FR' => 'France',
            'MA' => 'Maroc',
            'SA' => 'Arabie Saoudite',
            'DE' => 'Allemagne',
            'IT' => 'Italie',
            'ES' => 'Espagne',
            'US' => 'États-Unis',
            'CA' => 'Canada',
            'GB' => 'Royaume-Uni',
            'EU' => 'Union Européenne',
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Configuration des notifications fiscales
    |--------------------------------------------------------------------------
    */
    
    'notifications' => [
        'fiscales' => [
            'activer' => env('FACTURATION_FISCALE_ACTIVE', true),
            'delai_notification' => 24, // heures
            'methodes' => [
                'email',
                'api',
                'webhook',
            ],
        ],
        'retard_paiement' => [
            'activer' => env('NOTIFICATIONS_RETARD_ACTIVE', true),
            'delais_rappel' => [3, 7, 15, 30], // jours après échéance
        ],
    ],
];