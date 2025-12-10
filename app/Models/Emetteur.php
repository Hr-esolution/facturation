<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emetteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'entreprise',
        'adresse',
        'ville',
        'code_postal',
        'pays',
        'email',
        'telephone',
        'siret',                 // France
        'siren',                 // France
        'ape',                   // France
        'numero_tva_intracommunautaire', // EU/FR
        'ice',                   // Maroc
        'if',                    // Impôt sur les sociétés - Maroc
        'rc',                    // Registre de commerce - Maroc
        'patente',               // Patente fiscale - Maroc
        'numero_gst_hst_qst',    // Canada
        'numero_enregistrement', // Canada
        'ein',                   // US
        'state_sales_tax',       // US
        'zip_code',              // US
    ];

    protected $casts = [
        'adresse' => 'array',
    ];

    public function factures()
    {
        return $this->hasMany(Facture::class);
    }
}