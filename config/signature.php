<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuration de la signature électronique
    |--------------------------------------------------------------------------
    |
    | Paramètres pour la génération et la vérification des signatures électroniques
    | conformes aux normes AES (Advanced Electronic Signature) et QES (Qualified)
    |
    */
    
    'aes' => [
        'enabled' => true,
        'algorithm' => 'sha256',
        'certificate_path' => env('SIGNATURE_CERT_PATH', storage_path('app/certs/signature_cert.pem')),
        'private_key_path' => env('SIGNATURE_PRIVATE_KEY_PATH', storage_path('app/certs/signature_key.pem')),
        'private_key_passphrase' => env('SIGNATURE_PRIVATE_KEY_PASSPHRASE', ''),
        'validity_period' => 365, // jours
        'metadata_fields' => [
            'timestamp',
            'facture_id',
            'hash',
            'signature_type',
            'certificate_info',
        ],
    ],
    
    'qes' => [
        'enabled' => false, // Désactivé par défaut, nécessite un fournisseur certifié
        'provider' => env('QES_PROVIDER', 'default'),
        'api_url' => env('QES_API_URL', ''),
        'api_key' => env('QES_API_KEY', ''),
        'certificate_chain_path' => env('QES_CERT_CHAIN_PATH', ''),
    ],
    
    'formats' => [
        'supported' => [
            'pdf',  // Signature dans le PDF
            'xml',  // Signature XML pour échange électronique
            'json', // Signature des métadonnées
        ],
        'pdf' => [
            'visible_signature' => true,
            'position' => [
                'x' => 50,
                'y' => 50,
            ],
            'size' => [
                'width' => 150,
                'height' => 50,
            ],
            'appearance' => [
                'show_certificate' => true,
                'show_timestamp' => true,
                'show_hash' => false, // Pour des raisons de confidentialité
            ],
        ],
    ],
    
    'certificates' => [
        'auto_generate' => env('SIGNATURE_AUTO_GENERATE_CERT', false),
        'organization' => env('SIGNATURE_ORGANIZATION', 'InvoFlex'),
        'organization_unit' => env('SIGNATURE_ORGANIZATION_UNIT', 'Finance Department'),
        'country' => env('SIGNATURE_COUNTRY', 'FR'),
        'state' => env('SIGNATURE_STATE', 'Ile-de-France'),
        'locality' => env('SIGNATURE_LOCALITY', 'Paris'),
        'common_name' => env('SIGNATURE_COMMON_NAME', 'invoices.' . env('APP_DOMAIN', 'example.com')),
    ],
    
    'security' => [
        'hash_algorithm' => 'sha256',
        'encryption_method' => 'aes-256-cbc',
        'key_length' => 256,
        'require_timestamp' => true,
        'timestamp_authority_url' => env('TIMESTAMP_AUTHORITY_URL', 'http://timestamp.digicert.com'),
    ],
    
    'validation' => [
        'require_certificate_validation' => true,
        'check_certificate_revocation' => true,
        'verify_signature_integrity' => true,
        'trusted_certificates_path' => storage_path('app/certs/trusted'),
        'max_certificate_age' => 365, // jours
    ],
    
    'storage' => [
        'signatures_path' => storage_path('app/signatures'),
        'certificates_path' => storage_path('app/certs'),
        'backup_enabled' => true,
        'backup_path' => storage_path('app/backups/signatures'),
    ],
    
    'logging' => [
        'enabled' => true,
        'level' => 'info',
        'log_file' => 'signatures.log',
    ],
];