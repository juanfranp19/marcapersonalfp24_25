<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;

class AutorizacionEmpresaTest extends TestCase
{
    // use RefreshDatabase;

    private static $apiurl_empresa = '/api/v1/empresas';

    public function empresaIndex() : TestResponse
    {
        return $this->get(self::$apiurl_empresa);
    }

    public function empresaShow() : TestResponse
    {
        $empresa = Empresa::inRandomOrder()->first();
        return $this->get(self::$apiurl_empresa . "/{$empresa->id}");
    }

    public function empresaStore() : TestResponse
    {
        $data = [
            'user_id' => 1,
            'nif' => '123456J',
            'nombre' => 'Empresa de Prueba',
            'email' => 'sdadf@skljhnd.co,'

        ];
        return $this->postJson(self::$apiurl_empresa, $data);
    }

    public function empresaUpdate($propio = false) : TestResponse
    {
        $empresa = $propio
        ? Empresa::create(['user_id' => Auth::user()->id, 'nombre' => 'hola modificado'])
            : Empresa::inRandomOrder()->first();
        $data = [
            'user_id' => 1,
            'nif' => '123456J',
            'nombre' => 'Empresa de Prueba',
            'email' => 'sdadf@skljhnd.co,'
        ];
        return $this->putJson(self::$apiurl_empresa . "/{$empresa->id}", $data);
    }

    public function empresaDelete($propio = false) : TestResponse
    {
        $empresa = $propio
            ? Empresa::create(['user_id' => Auth::user()->id, 'nif' => '123456z', 'nombre' => 'Empresa de Prueba', 'email' => 'kjhasdk@klahs.com'])
            : Empresa::inRandomOrder()->first();
        return $this->delete(self::$apiurl_empresa . "/{$empresa->id}");
    }

    public function test_anonymous_can_access_curriculo_list_and_view()
    {
        $this->assertGuest();

        $response = $this->empresaIndex();
        $response->assertStatus(200);

        $response = $this->empresaShow();
        $response->assertStatus(200);

        $response = $this->empresaStore();
        $response->assertUnauthorized();

        $response = $this->empresaUpdate();
        $response->assertUnauthorized();

        $response = $this->empresaDelete();
        $response->assertFound();

    }

    public function test_admin_can_CRUD_empresa()
    {
        $admin = User::where('email', env('ADMIN_EMAIL'))->first();
        $this->actingAs($admin);

        $response = $this->empresaIndex();
        $response->assertSuccessful();

        $response = $this->empresaShow();
        $response->assertSuccessful();

        $response = $this->empresaStore();
        $response->assertSuccessful();

        $response = $this->empresaUpdate();
        $response->assertSuccessful();

        $response = $this->empresaDelete();
        $response->assertSuccessful();
    }

    public function test_docente_can_access_empresa_list_and_view()
    {
        $docente = User::where([
                ['email', 'like', '%@' . env('TEACHER_EMAIL_DOMAIN')],
                ['email', '!=', env('ADMIN_EMAIL')],
            ])->first();
        $this->actingAs($docente);

        $response = $this->empresaIndex();
        $response->assertSuccessful();

        $response = $this->empresaShow();
        $response->assertSuccessful();

        $response = $this->empresaStore();
        $response->assertForbidden();

        $response = $this->empresaUpdate();
        $response->assertForbidden();

        $response = $this->empresaDelete();
        $response->assertForbidden();
    }


    public function test_estudiante_can_CRUD_empresa_if_owner()
    {
        $estudiante = User::where('email', 'like', '%@' . env('STUDENT_EMAIL_DOMAIN'))->first();
        $this->actingAs($estudiante);

        $response = $this->empresaIndex();
        $response->assertSuccessful();

        $response = $this->empresaShow();
        $response->assertSuccessful();

        $response = $this->empresaStore();
        $response->assertSuccessful();

        $response = $this->empresaUpdate($propio = true);
        $response->assertSuccessful();

        $response = $this->empresaUpdate($propio = false);
        $response->assertForbidden();

        $response = $this->empresaDelete($propio = true);
        $response->assertSuccessful();

        $response = $this->empresaDelete($propio = false);
        $response->assertForbidden();
    }

}


?>
