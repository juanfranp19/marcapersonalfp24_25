<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurriculoControllerTest extends TestCase
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
         * curriculos index test.
         */
            $response = $this->get('/curriculos');
            $texto_curriculum = [
                "Experiencia en desarrollo web con enfoque en tecnologías front-end.",
                "Habilidades avanzadas en HTML, CSS y JavaScript.",
                "Amplia experiencia en el diseño y desarrollo de interfaces de usuario.",
                "Conocimientos sólidos en frameworks front-end como React y Vue.",
                "Experiencia en integración de API y consumo de servicios web.",
                "Habilidades de resolución de problemas y pensamiento lógico.",
                "Colaborador proactivo y eficiente en entornos de trabajo en equipo.",
                "Capacidad para aprender rápidamente nuevas tecnologías y conceptos.",
                "Comprometido con la mejora continua y el desarrollo profesional.",
                "Comunicación efectiva y habilidades interpersonales.",
            ];

            $response
            ->assertStatus(200)
            ->assertViewIs('curriculos.index')
            ->assertSeeTextInOrder($texto_curriculum, $escaped = true);

        /**
         * curriculos show test.
         */
            $response = $this->get("/curriculos/show/0");

            $response
            ->assertStatus(200)
            ->assertViewIs('curriculos.show')
            ->assertSeeText("Experiencia en desarrollo web con enfoque en tecnologías front-end.", $escaped = true);

            $response = $this->get("/curriculos/show/1");

            $response
            ->assertSeeText("Habilidades avanzadas en HTML, CSS y JavaScript.", $escaped = true);

            $response = $this->get("/curriculos/show/A");
            $response->assertNotFound();

        /**
         * curriculos create test.
         */
            $value = 'Añadir Currículum';
            $response = $this->get('/curriculos/create');

            $response
            ->assertStatus(200)
            ->assertViewIs('curriculos.create')
            ->assertSeeText($value, $escaped = true);

        /**
         * curriculos edit test.
         */
            $id = rand(1, 10);
            $value = "Modificar Currículum";
            $response = $this->get("/curriculos/edit/$id");

            $response
            ->assertStatus(200)
            ->assertViewIs('curriculos.edit')
            ->assertSeeText($value, $escaped = true);

            $response = $this->get("/curriculos/edit/A");
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
