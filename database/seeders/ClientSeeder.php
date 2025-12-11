<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\User;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        foreach ($users as $user) {
            Client::factory()->create([
                'user_id' => $user->id,
                'nom' => 'Doe',
                'prenom' => 'John',
                'entreprise' => 'Acme Corporation',
                'adresse' => json_encode(['rue' => '123 Main Street', 'complement' => 'Bureau 101']),
                'ville' => 'New York',
                'code_postal' => '10001',
                'pays' => 'US',
                'email' => 'john.doe@example.com',
                'telephone' => '+1-555-123-4567',
            ]);

            Client::factory()->create([
                'user_id' => $user->id,
                'nom' => 'Smith',
                'prenom' => 'Jane',
                'entreprise' => 'Globex Inc',
                'adresse' => json_encode(['rue' => '456 Oak Avenue', 'complement' => 'Suite 200']),
                'ville' => 'Los Angeles',
                'code_postal' => '90001',
                'pays' => 'US',
                'email' => 'jane.smith@example.com',
                'telephone' => '+1-555-987-6543',
            ]);

            // Create additional random clients
            Client::factory(3)->create(['user_id' => $user->id]);
        }
    }
}