<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'titre',
        'description',
        'contenu',
        'pays_concerne',
        'est_actif',
        'est_par_defaut',
        'parametres',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'est_actif' => 'boolean',
        'est_par_defaut' => 'boolean',
        'parametres' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Activer/désactiver un template
     */
    public function toggleStatus(): void
    {
        $this->update(['est_actif' => !$this->est_actif]);
    }

    /**
     * Définir comme template par défaut
     */
    public function setAsDefault(): void
    {
        // Désactiver tous les autres templates par défaut
        static::where('est_par_defaut', true)->update(['est_par_defaut' => false]);
        
        // Activer ce template comme par défaut
        $this->update(['est_par_defaut' => true]);
    }
}