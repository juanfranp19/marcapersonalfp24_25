<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
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
         * users index test.
         */
            $response = $this->get('/users');
            $nombres = [
                'John Doe',
                'Jane Smith',
                'Alice Johnson',
                'Bob Williams',
                'Eva Brown',
                'Michael Taylor',
                'Sophie Miller',
                'David Davis',
                'Emily White',
                'Tom Wilson',
            ];

            $response
            ->assertStatus(200)
            ->assertViewIs('users.index')
            ->assertSeeTextInOrder($nombres, $escaped = true);

        /**
         * users show test.
         */
            $response = $this->get("/users/show/1");

            $response
            ->assertStatus(200)
            ->assertViewIs('users.show')
            ->assertSeeText('Jane', $escaped = true);

            $response = $this->get("/users/show/2");

            $response
            ->assertSeeText('Alice', $escaped = true);

            $response = $this->get("/users/show/A");
            $response->assertNotFound();

        /**
         * users create test.
         */
            $value = 'Añadir usuario';
            $response = $this->get('/users/create');

            $response
            ->assertStatus(200)
            ->assertViewIs('users.create')
            ->assertSeeText($value, $escaped = true);

        /**
         * users edit test.
         */
            $id = rand(1, 10);
            $value = "Modificar usuario";
            $response = $this->get("/users/edit/$id");

            $response
            ->assertStatus(200)
            ->assertViewIs('users.edit')
            ->assertSeeText($value, $escaped = true);

            $response = $this->get("/users/edit/A");
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
