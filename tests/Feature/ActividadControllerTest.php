<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActividadControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_controladores(): void
    {
        /**
         * actividades index test.
         */
        $response = $this->get('/actividades');

        $response
        ->assertStatus(200)
        ->assertViewIs('actividades.index');

        /**
         * actividades show test.
         */
            $response = $this->get("/actividades/show/1");

            $response
            ->assertStatus(200)
            ->assertViewIs('actividades.show')
            ->assertSeeText('Docente: 2', $escaped = true);

            $response = $this->get("/actividades/show/2");

            $response
            ->assertSeeText('Docente: 3', $escaped = true);

            $response = $this->get("/actividades/show/A");
            $response->assertNotFound();

        /**
         * actividades create test.
         */
            $value = 'Añadir actividad';
            $response = $this->get('/actividades/create');

            $response
            ->assertStatus(200)
            ->assertViewIs('actividades.create')
            ->assertSeeText($value, $escaped = true);

        /**
         * actividades edit test.
         */
            $id = rand(0, 9);
            $value = "Modificar actividad";
            $response = $this->get("/actividades/edit/$id");

            $response
            ->assertStatus(200)
            ->assertViewIs('actividades.edit')
            ->assertSeeText($value, $escaped = true);

            $response = $this->get("/actividades/edit/A");
            $response->assertNotFound();

    }
}
