<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facture;
use App\Models\User;

class FactureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        foreach ($users as $user) {
            // Get associated clients and émetteurs for this user
            $clients = \App\Models\Client::where('user_id', $user->id)->get();
            $emetteurs = \App\Models\Emetteur::where('user_id', $user->id)->get();
            
            if ($clients->count() > 0 && $emetteurs->count() > 0) {
                // Create factures for each client with random émetteurs
                foreach ($clients as $client) {
                    $emetteur = $emetteurs->random();
                    
                    Facture::factory()->create([
                        'user_id' => $user->id,
                        'client_id' => $client->id,
                        'emetteur_id' => $emetteur->id,
                        'numero_facture' => 'FAC-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT),
                        'date_facture' => now()->subDays(rand(0, 30))->format('Y-m-d'),
                        'date_echeance' => now()->addDays(rand(15, 60))->format('Y-m-d'),
                        'statut' => collect(['brouillon', 'envoyee', 'payee', 'en_retard'])->random(),
                        'montant_ht' => rand(1000, 10000) / 100,
                        'taux_tva' => collect([0, 5.5, 10, 20])->random(),
                        'montant_ttc' => rand(1200, 12000) / 100,
                        'methode_paiement' => collect(['virement', 'cheque', 'carte_bancaire', 'paypal'])->random(),
                        'notes' => 'Facture générée automatiquement pour test',
                    ]);
                    
                    // Create additional random factures
                    Facture::factory(2)->create([
                        'user_id' => $user->id,
                        'client_id' => $client->id,
                        'emetteur_id' => $emetteur->id,
                    ]);
                }
            } else {
                // If no clients or émetteurs exist for this user, create some first
                $client = \App\Models\Client::factory()->create(['user_id' => $user->id]);
                $emetteur = \App\Models\Emetteur::factory()->create(['user_id' => $user->id]);
                
                Facture::factory()->create([
                    'user_id' => $user->id,
                    'client_id' => $client->id,
                    'emetteur_id' => $emetteur->id,
                    'numero_facture' => 'FAC-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT),
                    'date_facture' => now()->subDays(rand(0, 30))->format('Y-m-d'),
                    'date_echeance' => now()->addDays(rand(15, 60))->format('Y-m-d'),
                    'statut' => collect(['brouillon', 'envoyee', 'payee', 'en_retard'])->random(),
                    'montant_ht' => rand(1000, 10000) / 100,
                    'taux_tva' => collect([0, 5.5, 10, 20])->random(),
                    'montant_ttc' => rand(1200, 12000) / 100,
                    'methode_paiement' => collect(['virement', 'cheque', 'carte_bancaire', 'paypal'])->random(),
                    'notes' => 'Facture générée automatiquement pour test',
                ]);
            }
        }
    }
}