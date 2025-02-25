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

    public function test_docente_can_access_curriculo_list_and_view()
    {
        $docente = User::where([
            ['email', 'like', '%@' . env('TEACHER_EMAIL_DOMAIN')],
            ['email', '<>' , env('ADMIN_EMAIL')]
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
}
