<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\FamiliaProfesional;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;

class AutorizacionFamiliaProfesionalTest extends TestCase
{
    // use RefreshDatabase;

    private static $apiurl_familiaprofesional = '/api/v1/familias_profesionales';

    public function familiaProfesionalIndex() : TestResponse
    {
        return $this->get(self::$apiurl_familiaprofesional);
    }

    public function familiaProfesionalShow() : TestResponse
    {
        $familiaprofesional = FamiliaProfesional::inRandomOrder()->first();
        return $this->get(self::$apiurl_familiaprofesional . "/{$familiaprofesional->id}");
    }

    public function familiaProfesionalStore() : TestResponse
    {

        $data = [
            'id' => FamiliaProfesional::max('id') + 1,
            'codigo' => 'INF',
            'nombre' => 'Informática',
        ];
        return $this->postJson(self::$apiurl_familiaprofesional, json_decode(json_encode($data), true));
    }

        public function familiaProfesionalUpdate() : TestResponse
        {
            
        $familiaprofesional = FamiliaProfesional::inRandomOrder()->first();
        $data = [
            'id' => $familiaprofesional->id,
            'codigo' => 'INF',
            'nombre' => 'Informática2',
        ];
        return $this->putJson(self::$apiurl_familiaprofesional . "/{$familiaprofesional->id}", $data);
        }

    public function familiaProfesionalDelete($propio = false) : TestResponse
    {
        $familiaProfesional = $propio
        ? FamiliaProfesional::create(['codigo' => "ABC", 'nombre' => "Familia Test"])
        : FamiliaProfesional::inRandomOrder()->first();
        return $this->delete(self::$apiurl_familiaprofesional . "/{$familiaProfesional->id}");
    }

    public function test_anonymous_can_access_familiasprofesionales_list_and_view()
    {
        $this->assertGuest();

        $response = $this->familiaProfesionalIndex();
        $response->assertStatus(200);

        $response = $this->familiaProfesionalShow();
        $response->assertStatus(200);

        $response = $this->familiaProfesionalStore();
        $response->assertUnauthorized();

        $response = $this->familiaProfesionalUpdate();
        $response->assertUnauthorized();

        $response = $this->familiaProfesionalDelete();
        $response->assertFound();

    }

    public function test_admin_can_CRUD_familiasprofesionales()
    {
        $admin = User::where('email', env('ADMIN_EMAIL'))->first();
        $this->actingAs($admin);

        $response = $this->familiaProfesionalIndex();
        $response->assertSuccessful();

        $response = $this->familiaProfesionalShow();
        $response->assertSuccessful();

        $response = $this->familiaProfesionalStore();
        $response->assertSuccessful();

        $response = $this->familiaProfesionalUpdate();
        $response->assertSuccessful();

        $response = $this->familiaProfesionalDelete($propio = true);
        $response->assertSuccessful();

    }

    public function test_docente_can_access_familiasprofesionales_list_and_view()
    {
        $docente = User::where([
                ['email', 'like', '%@' . env('TEACHER_EMAIL_DOMAIN')],
                ['email', '!=', env('ADMIN_EMAIL')],
            ])->first();
        $this->actingAs($docente);

        $response = $this->familiaProfesionalIndex();
        $response->assertSuccessful();

        $response = $this->familiaProfesionalShow();
        $response->assertSuccessful();

        $response = $this->familiaProfesionalStore();
        $response->assertForbidden();

        $response = $this->familiaProfesionalUpdate();
        $response->assertForbidden();

        $response = $this->familiaProfesionalDelete();
        $response->assertForbidden();
    }


    public function test_estudiante_can_access_familiasprofesionales_list_and_view()
    {
        $estudiante = User::where('email', 'like', '%@' . env('STUDENT_EMAIL_DOMAIN'))->first();
        $this->actingAs($estudiante);

        $response = $this->familiaProfesionalIndex();
        $response->assertSuccessful();

        $response = $this->familiaProfesionalShow();
        $response->assertSuccessful();

        $response = $this->familiaProfesionalStore();
        $response->assertForbidden();

        $response = $this->familiaProfesionalUpdate();
        $response->assertForbidden();

        $response = $this->familiaProfesionalDelete();
        $response->assertForbidden();
    }

}
