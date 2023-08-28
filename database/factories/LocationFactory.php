<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'aisle' => fake()->streetName,
            'shelf' => fake()->numberBetween(1,3),
            'box_number' => fake()->numberBetween(1,50),
            'coordinates' => fake()->localCoordinates
        ];
    }
}
