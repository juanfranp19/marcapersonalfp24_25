<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProyectosCiclosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('proyectos_ciclos')->truncate();

        $ciclos = DB::table('ciclos')->get();
        $proyectos = DB::table('proyectos')->get();

        foreach ($ciclos as $ciclo) {

            foreach ($proyectos as $proyecto) {
                DB::table('proyectos_ciclos')->insert([
                    'proyecto_id' => $proyecto->id,
                    'ciclo_id' => $ciclo->id
                ]);
            }
        }

        $this->command->info('¡Tabla proyectos_ciclos inicializada con datos!');
    }
}
