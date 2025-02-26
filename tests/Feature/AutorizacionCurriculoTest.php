<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Curriculo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;

class AutorizacionCurriculoTest extends TestCase
{
    // use RefreshDatabase;

    private static $apiurl_curriculo = '/api/v1/curriculos';

    public function curriculoIndex() : TestResponse
    {
        return $this->get(self::$apiurl_curriculo);
    }

    public function curriculoShow() : TestResponse
    {
        $curriculo = Curriculo::inRandomOrder()->first();
        return $this->get(self::$apiurl_curriculo . "/{$curriculo->id}");
    }

    public function curriculoStore() : TestResponse
    {
        $data = [
            'user_id' => 1,
            'video_curriculo' => '123456',
        ];
        return $this->postJson(self::$apiurl_curriculo, $data);
    }

    public function curriculoUpdate($propio = false) : TestResponse
    {
        $curriculo = $propio
        ? Curriculo::create(['user_id' => Auth::user()->id, 'video_curriculum' => '123456'])
            : Curriculo::inRandomOrder()->first();
        $data = [
            'user_id' => 1,
            'video_curriculo' => '123456',
        ];
        return $this->putJson(self::$apiurl_curriculo . "/{$curriculo->id}", $data);
    }

    public function curriculoDelete($propio = false) : TestResponse
    {
        $curriculo = $propio
            ? Curriculo::create(['user_id' => Auth::user()->id, 'video_curriculum' => '123456'])
            : Curriculo::inRandomOrder()->first();
        return $this->delete(self::$apiurl_curriculo . "/{$curriculo->id}");
    }

    public function test_anonymous_can_access_curriculo_list_and_view()
    {
        $this->assertGuest();

        $response = $this->curriculoIndex();
        $response->assertStatus(200);

        $response = $this->curriculoShow();
        $response->assertStatus(200);

        $response = $this->curriculoStore();
        $response->assertUnauthorized();

        $response = $this->curriculoUpdate();
        $response->assertUnauthorized();

        $response = $this->curriculoDelete();
        $response->assertFound();

    }

    public function test_admin_can_CRUD_curriculo()
    {
        $admin = User::where('email', env('ADMIN_EMAIL'))->first();
        $this->actingAs($admin);

        $response = $this->curriculoIndex();
        $response->assertSuccessful();

        $response = $this->curriculoShow();
        $response->assertSuccessful();

        $response = $this->curriculoStore();
        $response->assertSuccessful();

        $response = $this->curriculoUpdate();
        $response->assertSuccessful();

        $response = $this->curriculoDelete();
        $response->assertSuccessful();
    }

    public function test_docente_can_access_curriculo_list_and_view()
    {
        $docente = User::where([
                ['email', 'like', '%@' . env('TEACHER_EMAIL_DOMAIN')],
                ['email', '!=', env('ADMIN_EMAIL')],
            ])->first();
        $this->actingAs($docente);

        $response = $this->curriculoIndex();
        $response->assertSuccessful();

        $response = $this->curriculoShow();
        $response->assertSuccessful();

        $response = $this->curriculoStore();
        $response->assertForbidden();

        $response = $this->curriculoUpdate();
        $response->assertForbidden();

        $response = $this->curriculoDelete();
        $response->assertForbidden();
    }


    public function test_estudiante_can_CRUD_curriculo_if_owner()
    {
        $estudiante = User::where('email', 'like', '%@' . env('STUDENT_EMAIL_DOMAIN'))->first();
        $this->actingAs($estudiante);

        $response = $this->curriculoIndex();
        $response->assertSuccessful();

        $response = $this->curriculoShow();
        $response->assertSuccessful();

        $response = $this->curriculoStore();
        $response->assertSuccessful();

        $response = $this->curriculoUpdate($propio = true);
        $response->assertSuccessful();

        $response = $this->curriculoUpdate($propio = false);
        $response->assertForbidden();

        $response = $this->curriculoDelete($propio = true);
        $response->assertSuccessful();

        $response = $this->curriculoDelete($propio = false);
        $response->assertForbidden();
    }

}
