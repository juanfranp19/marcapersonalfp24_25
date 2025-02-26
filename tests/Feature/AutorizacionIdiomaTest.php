<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Idiomas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;

class AutorizacionIdiomaTest extends TestCase
{
 // use RefreshDatabase;
 private static $apiurl_idiomas = '/api/v1/idiomas';
 public function idiomaIndex() : TestResponse
    {
        return $this->get(self::$apiurl_idiomas);
    }

    public function idiomaShow() : TestResponse
    {
        $idioma = Idiomas::inRandomOrder()->first();
        return $this->get(self::$apiurl_idiomas . "/{$idioma->id}");
    }

    public function idiomaStore() : TestResponse
    {
        $data = [
            'id' => Idiomas::max('id') + 1,
            'alpha2' => 'es',
            'alpha3t' => 'esp',
            'alpha3b' => 'spa',
            'english_name' => 'Spanish',
            'native_name' => 'Español',
        ];
        return $this->postJson(self::$apiurl_idiomas, json_decode(json_encode($data), true));
    }

    public function idiomaUpdate() : TestResponse
    {
        $idioma = Idiomas::inRandomOrder()->first();
        $data = [
            'id' => $idioma->id,
            'alpha2' => 'es',
            'alpha3t' => 'esp',
            'alpha3b' => 'spa',
            'english_name' => 'Spanish',
            'native_name' => 'Español',
        ];
        return $this->putJson(self::$apiurl_idiomas . "/{$idioma->id}", $data);
    }

    public function idiomaDelete() : TestResponse
    {
        $idioma = Idiomas::inRandomOrder()->first();

        if (!$idioma) {
            $idioma = Idiomas::create([
                'id' => $idioma->id,
                'alpha2' => 'es',
                'alpha3t' => 'esp',
                'alpha3b' => 'spa',
                'english_name' => 'Spanish',
                'native_name' => 'Español',
            ]);
        }
        return $this->delete(self::$apiurl_idiomas . "/{$idioma->id}");
    }

    public function test_anonymous_can_access_idiomas_list_and_view()
    {
        $this->assertGuest();

        $response = $this->idiomaIndex();
        $response->assertStatus(200);

        $response = $this->idiomaShow();
        $response->assertStatus(200);

        $response = $this->idiomaStore();
        $response->assertUnauthorized();

        $response = $this->idiomaUpdate();
        $response->assertUnauthorized();

        $response = $this->idiomaDelete();
        $response->assertFound();
    }

    public function test_admin_can_CRUD_idiomas()
    {
        $admin = User::where('email', env('ADMIN_EMAIL'))->first();
        $this->actingAs($admin);

        $response = $this->idiomaIndex();
        $response->assertSuccessful();

        $response = $this->idiomaShow();
        $response->assertSuccessful();

        $response = $this->idiomaStore();
        $response->assertSuccessful();

        $response = $this->idiomaUpdate();
        $response->assertSuccessful();

        $response = $this->idiomaDelete();
        $response->assertSuccessful();
    }

    public function test_docente_can_access_idiomas_list_and_view()
    {
        $docente = User::where([
                ['email', 'like', '%@' . env('TEACHER_EMAIL_DOMAIN')],
                ['email', '!=', env('ADMIN_EMAIL')],
            ])->first();
        $this->actingAs($docente);

        $response = $this->idiomaIndex();
        $response->assertSuccessful();

        $response = $this->idiomaShow();
        $response->assertSuccessful();

        $response = $this->idiomaStore();
        $response->assertForbidden();

        $response = $this->idiomaUpdate();
        $response->assertForbidden();

        $response = $this->idiomaDelete();
        $response->assertForbidden();
    }

    public function test_estudiante_can_access_idiomas_list_and_view()
    {
        $estudiante = User::where('email', 'like', '%@' . env('STUDENT_EMAIL_DOMAIN'))->first();
        $this->actingAs($estudiante);

        $response = $this->idiomaIndex();
        $response->assertSuccessful();

        $response = $this->idiomaShow();
        $response->assertSuccessful();

        $response = $this->idiomaStore();
        $response->assertForbidden();

        $response = $this->idiomaUpdate();
        $response->assertForbidden();

        $response = $this->idiomaDelete();
        $response->assertForbidden();
    }

 }
