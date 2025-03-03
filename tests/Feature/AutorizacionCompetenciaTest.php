<?php

namespace Tests\Feature;

use App\Models\Competencia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;

class AutorizacionCompetenciaTest extends TestCase
{
    private static $apiurl_competencia = '/api/v1/competencias';

    public function competenciaIndex() : TestResponse
    {
        return $this->get(self::$apiurl_competencia);
    }

    public function competenciaShow() : TestResponse
    {
        $competencia = Competencia::inRandomOrder()->first();
        return $this->get(self::$apiurl_competencia . "/{$competencia->id}");
    }

    public function competenciaStore() : TestResponse
    {
        $data = [
            'nombre' => 'Competencia',
            'color' => '#f6f6f6',
        ];
        return $this->postJson(self::$apiurl_competencia, $data);
    }

    public function competenciaUpdate() : TestResponse
    {
        $competencia = Competencia::inRandomOrder()->first();
        $data = [
            'nombre' => 'Competencia',
            'color' => '#f6f6f6',
        ];
        return $this->putJson(self::$apiurl_competencia . "/{$competencia->id}", $data);
    }

    public function competenciaDelete() : TestResponse
    {
        $competencia = Competencia::inRandomOrder()->first();
        return $this->delete(self::$apiurl_competencia . "/{$competencia->id}");
    }

    public function test_anonymous_can_access_competencia_list_and_view()
    {
        $this->assertGuest();

        $response = $this->competenciaIndex();
        $response->assertStatus(200);

        $response = $this->competenciaShow();
        $response->assertStatus(200);

        $response = $this->competenciaStore();
        $response->assertUnauthorized();

        $response = $this->competenciaUpdate();
        $response->assertUnauthorized();

        $response = $this->competenciaDelete();
        $response->assertFound();
    }

    public function test_admin_can_CRUD_competencias()
    {
        $admin = User::where('email', env('ADMIN_EMAIL'))->first();
        $this->actingAs($admin);

        $response = $this->competenciaIndex();
        $response->assertSuccessful();

        $response = $this->competenciaShow();
        $response->assertSuccessful();

        $response = $this->competenciaStore();
        $response->assertSuccessful();

        $response = $this->competenciaUpdate();
        $response->assertSuccessful();

        $response = $this->competenciaDelete();
        $response->assertSuccessful();
    }

    public function test_docente_can_access_competencia_list_and_view()
    {
        $docente = User::where([
            ['email', 'like', '%@' . env('TEACHER_EMAIL_DOMAIN')],
            ['email', '!=', env('ADMIN_EMAIL')],
        ])->first();
        $this->actingAs($docente);

        $response = $this->competenciaIndex();
        $response->assertSuccessful();

        $response = $this->competenciaShow();
        $response->assertSuccessful();

        $response = $this->competenciaStore();
        $response->assertForbidden();

        $response = $this->competenciaUpdate();
        $response->assertForbidden();

        $response = $this->competenciaDelete();
        $response->assertForbidden();
    }

    public function test_estudiante_can_access_competencia_list_and_view()
    {
        $estudiante = User::where([
            ['email', 'like', '%@' . env('STUDENT_EMAIL_DOMAIN')],
            ['email', '!=', env('ADMIN_EMAIL')],
        ])->first();
        $this->actingAs($estudiante);

        $response = $this->competenciaIndex();
        $response->assertSuccessful();

        $response = $this->competenciaShow();
        $response->assertSuccessful();

        $response = $this->competenciaStore();
        $response->assertForbidden();

        $response = $this->competenciaUpdate();
        $response->assertForbidden();

        $response = $this->competenciaDelete();
        $response->assertForbidden();
    }
}
