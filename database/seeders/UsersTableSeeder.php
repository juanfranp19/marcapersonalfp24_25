<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() == 0) {
            // Admin User
            User::factory()->create([
                'name' => 'Admin User',
                'email' => env('ADMIN_EMAIL', 'admin@admin.com'),
                'password' => bcrypt(env('ADMIN_PASSWORD', 'password')),
            ]);

            if (config('app.env') === 'local') {
                // Crear 10 usuarios con el estado docente
                User::factory(10)->docente()->create();
                // Crear 30 usuarios con el estado estudiante
                User::factory(30)->estudiante()->create();
            }
        }
    }
}
