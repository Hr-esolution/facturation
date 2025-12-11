<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Emetteur;
use App\Models\User;

class EmetteurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        foreach ($users as $user) {
            Emetteur::factory()->create([
                'user_id' => $user->id,
                'nom' => 'Williams',
                'prenom' => 'Robert',
                'entreprise' => 'Initech LLC',
                'adresse' => json_encode(['rue' => '789 Pine Road', 'complement' => 'Bâtiment A']),
                'ville' => 'Chicago',
                'code_postal' => '60601',
                'pays' => 'US',
                'email' => 'robert.williams@example.com',
                'telephone' => '+1-555-456-7890',
                'siret' => '123 456 789 00012', // French format
                'siren' => '123 456 789',       // French format
                'ape' => '6202A',               // French APE code
            ]);

            Emetteur::factory()->create([
                'user_id' => $user->id,
                'nom' => 'Johnson',
                'prenom' => 'Emily',
                'entreprise' => 'Umbrella Corp',
                'adresse' => json_encode(['rue' => '321 Elm Street', 'complement' => 'Appartement 3B']),
                'ville' => 'Miami',
                'code_postal' => '33101',
                'pays' => 'US',
                'email' => 'emily.johnson@example.com',
                'telephone' => '+1-555-321-0987',
                'ice' => 'ICE123456789',        // Moroccan ICE
                'if' => 'IF123456',             // Moroccan tax number
                'rc' => 'RC12345',              // Moroccan commercial registry
                'patente' => 'PAT12345',        // Moroccan tax registration
            ]);

            // Create additional random émetteurs
            Emetteur::factory(3)->create(['user_id' => $user->id]);
        }
    }
}