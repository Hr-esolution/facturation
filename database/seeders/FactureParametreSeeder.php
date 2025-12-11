<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FactureParametre;

class FactureParametreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create standard invoice parameters
        FactureParametre::factory()->create([
            'cle' => 'entreprise_nom',
            'valeur' => 'Votre Entreprise SARL',
            'description' => 'Nom de l\'entreprise émettrice',
            'type' => 'text',
            'pays' => 'FR',
        ]);

        FactureParametre::factory()->create([
            'cle' => 'entreprise_siret',
            'valeur' => '123 456 789 00012',
            'description' => 'Numéro SIRET de l\'entreprise',
            'type' => 'text',
            'pays' => 'FR',
        ]);

        FactureParametre::factory()->create([
            'cle' => 'entreprise_adresse',
            'valeur' => '123 Rue de la République, 75001 Paris, France',
            'description' => 'Adresse de l\'entreprise',
            'type' => 'text',
            'pays' => 'FR',
        ]);

        FactureParametre::factory()->create([
            'cle' => 'entreprise_email',
            'valeur' => 'contact@votreentreprise.fr',
            'description' => 'Email de contact de l\'entreprise',
            'type' => 'text',
            'pays' => 'FR',
        ]);

        FactureParametre::factory()->create([
            'cle' => 'entreprise_telephone',
            'valeur' => '+33 1 23 45 67 89',
            'description' => 'Téléphone de l\'entreprise',
            'type' => 'text',
            'pays' => 'FR',
        ]);

        // Create Canadian parameters
        FactureParametre::factory()->create([
            'cle' => 'entreprise_numero_gst_hst',
            'valeur' => '123456789RT0001',
            'description' => 'Numéro GST/HST de l\'entreprise',
            'type' => 'text',
            'pays' => 'CA',
        ]);

        // Create Moroccan parameters
        FactureParametre::factory()->create([
            'cle' => 'entreprise_ice',
            'valeur' => '12345678900001',
            'description' => 'Identifiant Commun de l\'Entreprise (Maroc)',
            'type' => 'text',
            'pays' => 'MA',
        ]);

        // Create additional random parameters
        FactureParametre::factory(5)->create();
    }
}