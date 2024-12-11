<?php

namespace Tests\Feature;

use App\Models\Proyecto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProyectosDBTest extends TestCase
{
    use RefreshDatabase;

    // genera un test que inserte un proyecto en la base de datos, atendiendo a la migración.
    // posteriormente, debe comprobar que el proyecto se ha insertado correctamente.
    // finalmente, debe eliminar el proyecto de la base de datos y comprobar que se ha eliminado correctamente.
    public function test_proyecto(): void
    {
        $this->seed();

        $proyecto1 = new Proyecto();
        $proyecto1->docente_id = 5;
        $proyecto1->nombre = 'Proyecto1 de prueba';
        $proyecto1->dominio = 'dominio1prueba';
        $proyecto1->metadatos = serialize([
            'fecha_inicio' => '2023-01-15',
            'fecha_fin' => '2023-05-30',
            'calificacion' => 9.5
        ]);
        $proyecto1->save();

        $proyecto2 = new Proyecto();
        $proyecto2->docente_id = 5;
        $proyecto2->nombre = 'Proyecto2 de prueba';
        $proyecto2->dominio = 'dominio2prueba';
        $proyecto2->metadatos = serialize([
            'fecha_inicio' => '2023-01-15',
            'fecha_fin' => '2023-05-30',
            'calificacion' => 4.5
        ]);
        $proyecto2->save();

        // TODO
        // cuando esté creado el controlador de proyectos, se podrá utilizar la siguiente petición:
        // $response = $this->post('/proyectos', $proyecto);
        // $response->assertStatus(201);
        // mientras, lo insertamos directamente en la base de datos:

        $this->assertDatabaseHas('proyectos', [
            'dominio' => 'dominio1prueba',
        ]);


        /**
         * proyectos index test.
         */
        $response = $this->get('/proyectos');
        $nombres = [
            'Proyecto1 de prueba',
            'Proyecto2 de prueba',
        ];


        /**
         * proyectos show test.
         */
        $response = $this->get("/proyectos/show/" . $proyecto1->id);

        $response
        ->assertStatus(200)
        ->assertViewIs('proyectos.show')
        ->assertSeeText('Proyecto aprobado', $escaped = true);

        $response = $this->get("/proyectos/show/" . $proyecto2->id);

        $response
        ->assertSeeText('Proyecto suspenso', $escaped = true);

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

        $response = $this->get("/proyectos/edit/" . $proyecto1->id);

        $response
        ->assertStatus(200)
        ->assertViewIs('proyectos.edit');

        $response = $this->get("/proyectos/edit/A");
        $response->assertNotFound();



        // TODO
        // cuando esté creado el controlador de proyectos, se podrá utilizar la siguiente petición:
        // $response = $this->delete('/proyectos/1');
        // $response->assertStatus(302);
        // mientras, lo eliminamos directamente en la base de datos:
        // busca en la base de datos al Esudiante con el id $proyecto->id y lo elimina
        $proyecto = Proyecto::find($proyecto1->id);
        $proyecto->delete();

        $this->assertDatabaseMissing('proyectos', [
            'dominio' => 'dominio1prueba',
        ]);

    }
}
