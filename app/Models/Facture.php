<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'numero_facture',
        'emetteur_id',
        'client_id',
        'date_emission',
        'date_echeance',
        'produits',
        'total_ht',
        'total_tva',
        'total_ttc',
        'statut',
        'mode_paiement',
        'pays_client',
    ];

    protected $casts = [
        'date_emission' => 'date',
        'date_echeance' => 'date',
        'produits' => 'array',
    ];

    public function emetteur()
    {
        return $this->belongsTo(Emetteur::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}