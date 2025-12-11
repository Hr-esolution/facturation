<?php

namespace Database\Factories;

use App\Models\FactureTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class FactureTemplateFactory extends Factory
{
    protected $model = FactureTemplate::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->word . '_template',
            'titre' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'contenu' => $this->faker->paragraphs(3, true),
            'pays_concerne' => $this->faker->countryCode,
            'est_actif' => $this->faker->boolean,
            'est_par_defaut' => $this->faker->boolean,
            'parametres' => [
                'couleur_primaire' => $this->faker->hexColor,
                'police' => $this->faker->randomElement(['Arial', 'Times New Roman', 'Helvetica', 'Verdana']),
                'logo_position' => $this->faker->randomElement(['haut', 'bas', 'gauche', 'droite']),
            ],
        ];
    }
}