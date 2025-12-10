<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'entreprise',
        'adresse',
        'ville',
        'code_postal',
        'pays',
        'email',
        'telephone',
        'ice',           // Maroc
        'if',            // Impôt sur les sociétés - Maroc
        'rc',            // Registre de commerce - Maroc
        'patente',       // Patente fiscale - Maroc
        'numero_tva_intracommunautaire', // EU/FR
        'adresse_complete',              // EU/FR
        'numero_gst_hst_qst',           // CA
        'numero_enregistrement',         // CA
        'ein',                          // US
        'state_sales_tax',              // US
        'zip_code',                     // US
    ];

    protected $casts = [
        'adresse' => 'array',
    ];

    public function factures()
    {
        return $this->hasMany(Facture::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}