<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActividadResource;
use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ActividadController extends Controller implements HasMiddleware
{
    public $modelclass = Actividad::class;

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return ActividadResource::collection(
            Actividad::orderBy($request->_sort ?? 'id', $request->_order ?? 'asc')
            ->paginate($request->perPage)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Actividad::class);

        $actividad = json_decode($request->getContent(), true);

        if (!$request->user()->esAdmin()) {
            $Actividad['docente_id'] = $request->user()->id;
        }

        $actividad = Actividad::create($actividad);

        return new ActividadResource($actividad);
    }

    /**
     * Display the specified resource.
     */
    public function show(Actividad $actividad)
    {
        return new ActividadResource($actividad);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Actividad $actividad)
    {
        Gate::authorize('update', $actividad);

        $actividadData = json_decode($request->getContent(), true);

        $actividad->update($actividadData);

        return new ActividadResource($actividad);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Actividad $actividad)
    {
        Gate::authorize('delete', $actividad);
        try {
            $actividad->delete();
            return response()->json(null, 204);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
}
