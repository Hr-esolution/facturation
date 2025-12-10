<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuration des PDF
    |--------------------------------------------------------------------------
    |
    | Paramètres pour la génération des PDF de factures avec prise en charge
    | des normes internationales et des exigences spécifiques par pays
    |
    */
    
    'generator' => [
        'engine' => 'dompdf', // Options: dompdf, tcpdf, wkhtmltopdf
        'default_paper_size' => 'A4',
        'default_orientation' => 'portrait',
        'default_font' => 'dejavu',
        'default_font_size' => 10,
    ],
    
    'templates' => [
        'default' => 'factures.templates.standard',
        'available' => [
            'standard' => 'factures.templates.standard',
            'pro' => 'factures.templates.pro',
            'compliant_eu' => 'factures.templates.compliant_eu',
            'compliant_maroc' => 'factures.templates.compliant_maroc',
            'compliant_usa' => 'factures.templates.compliant_usa',
            'compliant_canada' => 'factures.templates.compliant_canada',
            'compliant_sa' => 'factures.templates.compliant_sa', // Arabie Saoudite - ZATCA
            'qr_invoice' => 'factures.templates.qr_invoice',
            'signature_aes' => 'factures.templates.signature_aes',
        ],
        'custom_path' => resource_path('views/factures/templates'),
    ],
    
    'security' => [
        'enable_encryption' => false,
        'encryption_method' => 'RC4', // or 'AES'
        'permissions' => [
            'print' => true,
            'modify' => false,
            'copy' => false,
            'annot-forms' => false,
        ],
    ],
    
    'watermarks' => [
        'enabled' => false,
        'text' => 'CONFIDENTIAL',
        'opacity' => 0.3,
        'rotation' => -45,
        'font_size' => 50,
    ],
    
    'qr_codes' => [
        'enabled' => true,
        'size' => 100, // pixels
        'margin' => 2,
        'format' => 'png', // png, svg, eps
        'position' => [
            'x' => 150,
            'y' => 10,
        ],
        'include_in_templates' => [
            'compliant_sa',  // ZATCA (Arabie Saoudite)
            'qr_invoice',
            'signature_aes',
        ],
    ],
    
    'signatures' => [
        'visible' => true,
        'position' => [
            'x' => 50,
            'y' => 250,
        ],
        'size' => [
            'width' => 150,
            'height' => 50,
        ],
        'display_fields' => [
            'certificate' => true,
            'timestamp' => true,
            'signature_type' => true,
        ],
    ],
    
    'localization' => [
        'default_language' => 'fr',
        'supported_languages' => [
            'fr', 'en', 'ar', 'es', 'de', 'it',
        ],
        'date_format' => 'd/m/Y',
        'number_format' => [
            'decimals' => 2,
            'decimal_point' => ',',
            'thousands_separator' => ' ',
        ],
        'currency' => [
            'default' => 'EUR',
            'position' => 'after', // 'before' or 'after'
            'symbol' => '€',
            'decimals' => 2,
        ],
    ],
    
    'compliance' => [
        'eu' => [
            'show_vat_breakdown' => true,
            'show_ht_ttc' => true,
            'autoliquidation_mention' => true,
            'vat_format' => 'EU_VAT_FORMAT',
        ],
        'maroc' => [
            'show_ice' => true,
            'show_if' => true,
            'show_rc' => true,
            'show_patente' => true,
            'show_cnss' => false, // facultatif
        ],
        'usa' => [
            'show_ein' => true,
            'show_state_tax' => true,
            'show_zip_code' => true,
            'show_state_of_sale' => true,
        ],
        'canada' => [
            'show_gst_hst_qst' => true,
            'show_registration_number' => true,
            'show_canadian_tax' => true,
        ],
        'saudi_arabia' => [ // ZATCA
            'show_qr_code' => true,
            'qr_format' => 'ZATCA',
            'required_fields' => [
                'seller_name',
                'vat_number',
                'timestamp',
                'total_amount',
                'vat_amount',
            ],
        ],
    ],
    
    'storage' => [
        'path' => storage_path('app/invoices'),
        'public_path' => public_path('invoices'),
        'disk' => 'local',
        'file_naming' => [
            'format' => 'facture_{numero}_{date}_{client}', // placeholders: {numero}, {date}, {client}, {id}
            'date_format' => 'Y-m-d',
        ],
        'cleanup' => [
            'enabled' => true,
            'retention_days' => 365, // jours
        ],
    ],
    
    'performance' => [
        'async_generation' => true,
        'queue_connection' => 'database',
        'timeout' => 60, // secondes
        'memory_limit' => '256M',
    ],
    
    'debug' => [
        'enabled' => env('PDF_DEBUG', false),
        'log_path' => storage_path('logs/pdf_generation.log'),
    ],
];