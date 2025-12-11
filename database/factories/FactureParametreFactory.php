<?php

namespace Database\Factories;

use App\Models\FactureParametre;
use Illuminate\Database\Eloquent\Factories\Factory;

class FactureParametreFactory extends Factory
{
    protected $model = FactureParametre::class;

    public function definition(): array
    {
        return [
            'cle' => $this->faker->word,
            'valeur' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(['text', 'number', 'boolean', 'json']),
            'pays' => $this->faker->countryCode,
        ];
    }
}