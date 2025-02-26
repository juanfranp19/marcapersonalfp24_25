<?php

namespace Tests\Feature;

use App\Models\Ciclo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Curriculo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;

class AutorizacionCicloTest extends TestCase
{
    // use RefreshDatabase;

    private static $apiurl_ciclo = '/api/v1/ciclos';

    public function cicloIndex() : TestResponse
    {
        return $this->get(self::$apiurl_ciclo);
    }

    public function cicloShow() : TestResponse
    {
        $ciclo = Ciclo::inRandomOrder()->first();
        return $this->get(self::$apiurl_ciclo . "/{$ciclo->id}");
    }

    public function cicloStore() : TestResponse
    {
        $data = [
            'codCiclo' => 'PRUEB',
            'familia_id' => '1',
            'nombre' => 'cicloTest',
            'codFamilia' => 'ADG',
            'grado' => 'G.M.',
        ];
        return $this->postJson(self::$apiurl_ciclo, $data);
    }

    public function cicloUpdate() : TestResponse
    {
        $ciclo = Ciclo::create(['codCiclo' => 'PRUEB', 'familia_id' => '1', 'nombre' => '123456', 'codFamilia' => 'ADG', 'grado' => 'G.M.']);
        $data = [
            'codCiclo' => 'PRUEB',
            'familia_id' => '1',
            'nombre' => '123456',
            'codFamilia' => 'ADG',
            'grado' => 'G.M.',
        ];
        return $this->putJson(self::$apiurl_ciclo . "/{$ciclo->id}", $data);
    }

    public function cicloDelete() : TestResponse
    {
        $ciclo = Ciclo::create(['codCiclo' => 'PRUEB', 'familia_id' => '1', 'nombre' => '123456', 'codFamilia' => 'ADG', 'grado' => 'G.M.']);
        return $this->delete(self::$apiurl_ciclo . "/{$ciclo->id}");
    }

    public function test_anonymous_can_access_ciclo_list_and_view()
    {
        $this->assertGuest();

        $response = $this->cicloIndex();
        $response->assertStatus(200);

        $response = $this->cicloShow();
        $response->assertStatus(200);

        $response = $this->cicloStore();
        $response->assertUnauthorized();

        $response = $this->cicloUpdate();
        $response->assertUnauthorized();

        $response = $this->cicloDelete();
        $response->assertFound();

    }

    public function test_admin_can_CRUD_ciclo()
    {
        $admin = User::where('email', env('ADMIN_EMAIL'))->first();
        $this->actingAs($admin);

        $response = $this->cicloIndex();
        $response->assertSuccessful();

        $response = $this->cicloShow();
        $response->assertSuccessful();

        $response = $this->cicloStore();
        $response->assertSuccessful();

        $response = $this->cicloUpdate();
        $response->assertSuccessful();

        $response = $this->cicloDelete();
        $response->assertSuccessful();
    }

    public function test_docente_can_access_ciclo_list_and_view()
    {
        $docente = User::where([
                ['email', 'like', '%@' . env('TEACHER_EMAIL_DOMAIN')],
                ['email', '!=', env('ADMIN_EMAIL')],
            ])->first();
        $this->actingAs($docente);

        $response = $this->cicloIndex();
        $response->assertSuccessful();

        $response = $this->cicloShow();
        $response->assertSuccessful();

        $response = $this->cicloStore();
        $response->assertForbidden();

        $response = $this->cicloUpdate();
        $response->assertForbidden();

        $response = $this->cicloDelete();
        $response->assertForbidden();
    }


    public function test_estudiante_can_access_ciclo_list_and_view()
    {
        $estudiante = User::where('email', 'like', '%@' . env('STUDENT_EMAIL_DOMAIN'))->first();
        $this->actingAs($estudiante);

        $response = $this->cicloIndex();
        $response->assertSuccessful();

        $response = $this->cicloShow();
        $response->assertSuccessful();

        $response = $this->cicloStore();
        $response->assertForbidden();

        $response = $this->cicloUpdate();
        $response->assertForbidden();

        $response = $this->cicloDelete();
        $response->assertForbidden();
    }

}
