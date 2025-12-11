<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FactureChamp;

class FactureChampSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création de champs de facturation par défaut pour différents pays
        $champs = [
            // Champs communs
            [
                'nom' => 'numero_facture',
                'label' => 'Numéro de facture',
                'type' => 'text',
                'pays' => 'FR',
                'est_requis' => true,
                'valeur_defaut' => null,
                'options' => null,
                'ordre_affichage' => 1,
                'groupe' => 'identification'
            ],
            [
                'nom' => 'date_emission',
                'label' => 'Date d\'émission',
                'type' => 'date',
                'pays' => 'FR',
                'est_requis' => true,
                'valeur_defaut' => null,
                'options' => null,
                'ordre_affichage' => 2,
                'groupe' => 'identification'
            ],
            [
                'nom' => 'date_echeance',
                'label' => 'Date d\'échéance',
                'type' => 'date',
                'pays' => 'FR',
                'est_requis' => true,
                'valeur_defaut' => null,
                'options' => null,
                'ordre_affichage' => 3,
                'groupe' => 'identification'
            ],
            [
                'nom' => 'emetteur_nom',
                'label' => 'Nom de l\'émetteur',
                'type' => 'text',
                'pays' => 'FR',
                'est_requis' => true,
                'valeur_defaut' => null,
                'options' => null,
                'ordre_affichage' => 4,
                'groupe' => 'emetteur'
            ],
            [
                'nom' => 'client_nom',
                'label' => 'Nom du client',
                'type' => 'text',
                'pays' => 'FR',
                'est_requis' => true,
                'valeur_defaut' => null,
                'options' => null,
                'ordre_affichage' => 5,
                'groupe' => 'client'
            ],
            [
                'nom' => 'produits_designation',
                'label' => 'Désignation des produits',
                'type' => 'textarea',
                'pays' => 'FR',
                'est_requis' => true,
                'valeur_defaut' => null,
                'options' => null,
                'ordre_affichage' => 6,
                'groupe' => 'produits'
            ],
            [
                'nom' => 'produits_quantite',
                'label' => 'Quantité',
                'type' => 'number',
                'pays' => 'FR',
                'est_requis' => true,
                'valeur_defaut' => null,
                'options' => null,
                'ordre_affichage' => 7,
                'groupe' => 'produits'
            ],
            [
                'nom' => 'produits_prix_unitaire',
                'label' => 'Prix unitaire',
                'type' => 'number',
                'pays' => 'FR',
                'est_requis' => true,
                'valeur_defaut' => null,
                'options' => null,
                'ordre_affichage' => 8,
                'groupe' => 'produits'
            ],
            [
                'nom' => 'produits_taux_tva',
                'label' => 'Taux TVA (%)',
                'type' => 'number',
                'pays' => 'FR',
                'est_requis' => true,
                'valeur_defaut' => null,
                'options' => null,
                'ordre_affichage' => 9,
                'groupe' => 'produits'
            ],
            [
                'nom' => 'numero_facture',
                'label' => 'Invoice Number',
                'type' => 'text',
                'pays' => 'US',
                'est_requis' => true,
                'valeur_defaut' => null,
                'options' => null,
                'ordre_affichage' => 1,
                'groupe' => 'identification'
            ],
            [
                'nom' => 'date_emission',
                'label' => 'Issue Date',
                'type' => 'date',
                'pays' => 'US',
                'est_requis' => true,
                'valeur_defaut' => null,
                'options' => null,
                'ordre_affichage' => 2,
                'groupe' => 'identification'
            ],
            [
                'nom' => 'date_echeance',
                'label' => 'Due Date',
                'type' => 'date',
                'pays' => 'US',
                'est_requis' => true,
                'valeur_defaut' => null,
                'options' => null,
                'ordre_affichage' => 3,
                'groupe' => 'identification'
            ],
        ];

        foreach ($champs as $champ) {
            FactureChamp::firstOrCreate(
                ['nom' => $champ['nom'], 'pays' => $champ['pays']],
                $champ
            );
        }
    }
}