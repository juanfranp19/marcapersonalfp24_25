<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstudiantesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estudiantes')->truncate();
        Estudiante::factory(10)->create();
    }
}
