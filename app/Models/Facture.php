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
        'total_ht',
        'total_tva',
        'total_ttc',
        'statut',
        'mode_paiement',
        'pays_client',
        'template_id',
    ];

    protected $casts = [
        'date_emission' => 'date',
        'date_echeance' => 'date',
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

    public function produits()
    {
        return $this->belongsToMany(Product::class, 'facture_produits')
                    ->withPivot('quantite', 'prix_unitaire', 'taxe', 'sous_total')
                    ->withTimestamps();
    }

    public function template()
    {
        return $this->belongsTo(FactureTemplate::class);
    }
}