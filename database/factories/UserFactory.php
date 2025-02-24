<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nombre = fake()->firstName();
        $apellidos = fake()->lastName();
        $name = "$nombre $apellidos";
        return [
            'name' => $this->faker->unique()->numberBetween(1111111, 9999999),
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }


    /**
     * Indicate that the model's email  should be student.
     */
    public function estudiante(): static
    {
        return $this->state(fn(array $attributes) => [
            'email' => $attributes['name'] . '@' . env('STUDENT_EMAIL_DOMAIN', 'student.com'),
        ]);
    }

    /**
     * Indicate that the model's email  should be teacher.
     */
    public function docente(): static
    {
        return $this->state(fn(array $attributes) => [
            'email' => $attributes['name'] . '@' . env('TEACHER_EMAIL_DOMAIN', 'teacher.com'),
        ]);
    }
}
