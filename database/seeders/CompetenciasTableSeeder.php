<?php

namespace Database\Seeders;

use App\Models\Competencia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompetenciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Competencia::truncate();

        if (config('app.env') === 'local') {
            //Competencia::factory(10)->create();

            foreach (self::$arrayCompetencias as $competencia) {
                Competencia::factory()->create([
                    'nombre' => $competencia['nombre'],
                    'color' => fake()->hexColor()
                ]);
            };
        }
    }

    private static $arrayCompetencias = [
        [
            'nombre' => 'Comunicación',
        ],
        [
            'nombre' => 'Inteligencia emocional',
        ],
        [
            'nombre' => 'Pensamiento crítico',
        ],
        [
            'nombre' => 'Responsabilidad',
        ],
        [
            'nombre' => 'Gestión del cambio',
        ],
        [
            'nombre' => 'Creatividad',
        ],
    ];
}
