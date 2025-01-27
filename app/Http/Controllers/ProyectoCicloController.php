<?php

namespace App\Http\Controllers;

use App\Models\Ciclo;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoCicloController extends Controller
{
    public function indexProyectosCiclos($proyectoId)
    {
        $proyecto = Proyecto::findOrFail($proyectoId);
        $ciclos = $proyecto->ciclos;
        return response()->json($ciclos);
    }

    public function indexCiclosProyectos($cicloId)
    {
        $ciclo = Ciclo::findOrFail($cicloId);
        $proyectos = $ciclo->proyectos;
        return response()->json($proyectos);
    }

    public function storeProyectoCiclo(Request $request, $proyectoId)
    {
        $request->validate([
            'ciclo_id' => 'required|exists:ciclos,id'
        ]);

        $proyecto = Proyecto::findOrFail($proyectoId);

        $cicloId = $request->input('ciclo_id');
        $ciclo = Ciclo::findOrFail($cicloId);

        $proyecto->ciclos()->attach($ciclo);

        return response()->json($proyecto->ciclos);
    }

    public function storeCicloProyecto(Request $request, $cicloId)
    {
        $request->validate([
            'proyecto_id' => 'required|exists:proyectos,id'
        ]);

        $ciclo = Ciclo::findOrFail($cicloId);

        $proyectoId = $request->input('proyecto_id');
        $proyecto = Proyecto::findOrFail($proyectoId);

        $ciclo->proyectos()->attach($proyecto);

        return response()->json($ciclo->proyectos);
    }

    public function destroyProyectoCiclo($proyectoId, $cicloId)
    {
        $proyecto = Proyecto::findOrFail($proyectoId);
        $ciclo = Ciclo::findOrFail($cicloId);

        $proyecto->ciclos()->detach($ciclo);

        return response()->json($proyecto->ciclos);
    }

    public function destroyCicloProyecto($cicloId, $proyectoId)
    {
        $ciclo = Ciclo::findOrFail($cicloId);
        $proyecto = Proyecto::findOrFail($proyectoId);

        $ciclo->proyectos()->detach($proyecto);

        return response()->json($ciclo->proyectos);
    }
}
