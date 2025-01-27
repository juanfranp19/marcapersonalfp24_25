<?php

namespace Database\Seeders;

use App\Http\Controllers\ProyectoCicloController;
use App\Models\Ciclo;
use App\Models\Proyecto;
use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProyectosCiclosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncar la tabla pivote para empezar desde cero
        ProyectoCiclo::truncate();

        // Obtener todos los proyectos y ciclos
        $proyectos = Proyecto::all();
        $ciclos = Ciclo::all();

        // Asociar proyectos con ciclos
        foreach ($proyectos as $proyecto) {
            // Asocia un ciclo aleatorio a cada proyecto
            if ($ciclos->isNotEmpty()) {
                $proyecto->ciclos()->attach($ciclos->random()->id);
            }
        }

        $this->command->info('¡Tabla proyectos_ciclos inicializada con datos!');
    }
}
