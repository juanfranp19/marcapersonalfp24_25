<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;

class AutorizacionActividadTest extends TestCase
{
    // use RefreshDatabase;

    private static $apiurl_actividad = '/api/v1/actividades';

    public function actividadIndex() : TestResponse
    {
        return $this->get(self::$apiurl_actividad);
    }

    public function actividadShow() : TestResponse
    {
        $actividad = Actividad::inRandomOrder()->first();
        return $this->get(self::$apiurl_actividad . "/{$actividad->id}");
    }

    public function actividadStore() : TestResponse
    {
        $data = [
            'id' => 1,
            'docente_id' => 1,
            'insignia' => '123456',
        ];
        return $this->postJson(self::$apiurl_actividad, $data);
    }

    public function actividadUpdate($propio = false) : TestResponse
    {
        $actividad = $propio
        ? Actividad::create(['docente_id' => Auth::user()->id, 'insignia' => '123456'])
            : Actividad::inRandomOrder()->first();
            $data = [
                'id' => 1,
                'docente_id' => 1,
                'insignia' => '123456',
            ];
        return $this->putJson(self::$apiurl_actividad . "/{$actividad->id}", $data);
    }

    public function actividadDelete($propio = false) : TestResponse
    {
        $actividad = $propio
            ? Actividad::create(['docente_id' => Auth::user()->id, 'insignia' => '123456'])
            : Actividad::inRandomOrder()->first();
        return $this->delete(self::$apiurl_actividad . "/{$actividad->id}");
    }

    public function test_anonymous_can_access_actividad_list_and_view()
    {
        $this->assertGuest();

        $response = $this->actividadIndex();
        $response->assertStatus(200);

        $response = $this->actividadShow();
        $response->assertStatus(200);

        $response = $this->actividadStore();
        $response->assertUnauthorized();

        $response = $this->actividadUpdate();
        $response->assertUnauthorized();

        $response = $this->actividadDelete();
        $response->assertFound();

    }

    public function test_admin_can_CRUD_actividad()
    {
        $admin = User::where('email', env('ADMIN_EMAIL'))->first();
        $this->actingAs($admin);

        $response = $this->actividadIndex();
        $response->assertSuccessful();

        $response = $this->actividadShow();
        $response->assertSuccessful();

        $response = $this->actividadStore();
        $response->assertSuccessful();

        $response = $this->actividadUpdate();
        $response->assertSuccessful();

        $response = $this->actividadDelete();
        $response->assertSuccessful();
    }

    public function test_docente_can_access_actividad_list_and_view()
    {
        $docente = User::where([
            ['email', 'like', '%@' . env('TEACHER_EMAIL_DOMAIN')],
            ['email', '!=', env('ADMIN_EMAIL')],
        ])->first();

        $this->actingAs($docente);

        $response = $this->actividadIndex();
        $response->assertSuccessful();

        $response = $this->actividadShow();
        $response->assertSuccessful();

        $response = $this->actividadStore();
        $response->assertForbidden();

        $response = $this->actividadUpdate();
        $response->assertForbidden();

        $response = $this->actividadDelete();
        $response->assertForbidden();
    }


    public function test_docente_can_CRUD_actividad_if_owner()
    {
        $docente = User::where([
            ['email', 'like', '%@' . env('TEACHER_EMAIL_DOMAIN')],
            ['email', '!=', env('ADMIN_EMAIL')]
        ])->first();

        $this->actingAs($docente);

        $response = $this->actividadIndex();
        $response->assertSuccessful();

        $response = $this->actividadShow();
        $response->assertSuccessful();

        $response = $this->actividadStore();
        $response->assertSuccessful();

        $response = $this->actividadUpdate($propio = true);
        $response->assertSuccessful();

        $response = $this->actividadUpdate($propio = false);
        $response->assertForbidden();

        $response = $this->actividadDelete($propio = true);
        $response->assertSuccessful();

        $response = $this->actividadDelete($propio = false);
        $response->assertForbidden();
    }

}
