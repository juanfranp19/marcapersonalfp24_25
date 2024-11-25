<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReconocimientoControllerTest extends TestCase
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
         * reconocimiento index test.
         */
            $response = $this->get('/reconocimientos');
            $estudiante_id = [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
            ];

            $response
            ->assertStatus(200)
            ->assertViewIs('reconocimientos.index')
            ->assertSeeTextInOrder($estudiante_id, $escaped = true);

        /**
         * reconocimiento show test.
         */
            $response = $this->get("/reconocimientos/show/1");

            $response
            ->assertStatus(200)
            ->assertViewIs('reconocimientos.show')
            ->assertSeeText('2', $escaped = true);

            $response = $this->get("/reconocimientos/show/2");

            $response
            ->assertSeeText('3', $escaped = true);

            $response = $this->get("/reconocimientos/show/A");
            $response->assertNotFound();

        /**
         * reconocimiento create test.
         */
            $value = 'Añadir Reconocimiento';
            $response = $this->get('/reconocimientos/create');

            $response
            ->assertStatus(200)
            ->assertViewIs('reconocimientos.create')
            ->assertSeeText($value, $escaped = true);

        /**
         * reconocimiento edit test.
         */
            $id = rand(1, 10);
            $value = "Modificar Reconocimiento";
            $response = $this->get("/reconocimientos/edit/$id");

            $response
            ->assertStatus(200)
            ->assertViewIs('reconocimientos.edit')
            ->assertSeeText($value, $escaped = true);

            $response = $this->get("/reconocimientos/edit/A");
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
