<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProyectoControllerTest extends TestCase
{
    public function test_controladores(): void
    {
        /**
         * main page test.
         */
            $value = 'Pantalla principal';
            $response = $this->get('/');

            $response
                ->assertRedirect('/proyectos');

        /**
         * login test.
         */
            $value = 'Login usuario';
            $response = $this->get('/login');

            $response
            ->assertStatus(200)
            ->assertViewIs('auth.login')
            ->assertSeeText($value, $escaped = true);

        /**
         * logout test.
         */
            $value = 'Logout usuario';
            $response = $this->get('/logout');

            $response->assertStatus(200)->assertSeeText($value, $escaped = true);

        /**
         * proyectos index test.
         */
            $response = $this->get('/proyectos');
            $nombres = [
                'Tecnologías de la Información',
                'Diseño Gráfico',
                'Electrónica',
                'Ingeniería Civil',
                'Gastronomía',
                'Medicina',
                'Mecatrónica',
                'Arquitectura',
                'Automoción',
                'Turismo',
            ];

            $response
            ->assertStatus(200)
            ->assertViewIs('proyectos.index')
            ->assertSeeTextInOrder($nombres, $escaped = true);

        /**
         * proyectos show test.
         */
            $response = $this->get("/proyectos/show/1");

            $response
            ->assertStatus(200)
            ->assertViewIs('proyectos.show')
            ->assertSeeText('Diseño Gráfico', $escaped = true);

            $response = $this->get("/proyectos/show/2");

            $response
            ->assertSeeText('Electrónica', $escaped = true);

            $response = $this->get("/proyectos/show/A");
            $response->assertNotFound();

        /**
         * proyectos create test.
         */
            $value = 'Añadir proyecto';
            $response = $this->get('/proyectos/create');

            $response
            ->assertStatus(200)
            ->assertViewIs('proyectos.create')
            ->assertSeeText($value, $escaped = true);

        /**
         * proyectos edit test.
         */
            $id = rand(1, 10);
            $value = "Modificar proyecto";
            $response = $this->get("/proyectos/edit/$id");

            $response
            ->assertStatus(200)
            ->assertViewIs('proyectos.edit')
            ->assertSeeText($value, $escaped = true);

            $response = $this->get("/proyectos/edit/A");
            $response->assertNotFound();

        /**
         * perfil test.
         */
            $id = rand(1, 10);
            $value = "Visualizar el currículo de $id";
            $response = $this->get("/perfil/$id");

            $response->assertStatus(200)->assertSeeText($value, $escaped = true);

            $value = "Visualizar el currículo propio";
            $response = $this->get("/perfil");

            $response->assertStatus(200)->assertSeeText($value, $escaped = true);

            $response = $this->get("/perfil/" . chr($id));
            $response->assertNotFound();
    }
}
