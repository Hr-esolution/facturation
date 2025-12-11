<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'categorie',
        'designation',
        'description',
        'prix_unitaire',
        'taxe',
        'unite',
        'reference',
        'code_barre',
        'stock',
        'actif',
    ];

    protected $casts = [
        'prix_unitaire' => 'decimal:2',
        'taxe' => 'decimal:2',
        'actif' => 'boolean',
        'stock' => 'integer',
    ];

    public function factures()
    {
        return $this->belongsToMany(Facture::class, 'facture_produits')
                    ->withPivot('quantite', 'prix_unitaire', 'taxe', 'sous_total')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}