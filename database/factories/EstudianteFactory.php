<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estudiante>
 */
class EstudianteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->firstName(),
            'apellidos' => fake()->lastName(),
            'direccion' => fake()->address(),
            'votos' => fake()->numberBetween(50, 150),
            'confirmado' => fake()->boolean(),
            'ciclo' => fake()->randomElement(['ASIR', 'DAW', 'DAM']),
            'user_id' => null,
        ];
    }
}
