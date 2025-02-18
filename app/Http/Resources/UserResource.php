<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use function PHPUnit\Framework\isEmpty;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $admin = $this->administradores;
        unset($admin['user_id']);

        if ($admin == null) {
            $admin = false;
        }

        return array_merge(
            parent::toArray($request),
            ['actividades_estudiante' => $this->actividadesComoEstudiante],
            ['actividades_docente' => $this->actividadesComoDocente],
            ['competencias' => $this->competencias],
            ['curriculo' => $this->curriculo],
            ['ciclos' => $this->ciclos],
            ['proyectos' => $this->proyectos],
            ['admin' => $admin]
        );
    }
}
