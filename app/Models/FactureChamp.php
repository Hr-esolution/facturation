<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureChamp extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'label',
        'type',
        'pays',
        'est_requis',
        'valeur_defaut',
        'options',
        'ordre_affichage',
        'groupe',
        'regles_validation',
    ];

    protected $casts = [
        'options' => 'array',
        'regles_validation' => 'array',
        'est_requis' => 'boolean',
    ];
}