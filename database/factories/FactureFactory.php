<?php

namespace Database\Factories;

use App\Models\Facture;
use Illuminate\Database\Eloquent\Factories\Factory;

class FactureFactory extends Factory
{
    protected $model = Facture::class;

    public function definition(): array
    {
        return [
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'client_id' => function () {
                return \App\Models\Client::factory()->create()->id;
            },
            'emetteur_id' => function () {
                return \App\Models\Emetteur::factory()->create()->id;
            },
            'numero_facture' => $this->faker->unique()->numerify('FAC-#####'),
            'date_facture' => $this->faker->date(),
            'date_echeance' => $this->faker->date(),
            'statut' => $this->faker->randomElement(['brouillon', 'envoyee', 'payee', 'en_retard']),
            'montant_ht' => $this->faker->randomFloat(2, 100, 10000),
            'taux_tva' => $this->faker->randomElement([0, 5.5, 10, 20]),
            'montant_ttc' => $this->faker->randomFloat(2, 100, 12000),
            'methode_paiement' => $this->faker->randomElement(['virement', 'cheque', 'carte_bancaire', 'paypal']),
            'notes' => $this->faker->paragraph(),
        ];
    }
}