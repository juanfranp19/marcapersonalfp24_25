<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProyectoResource;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use PhpParser\Node\Stmt\TryCatch;

class ProyectoController extends Controller
{

    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
        ];
    }

    public $modelclass = Proyecto::class;
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        /** Hay 10 proyectos, con lo que en verdad el paginate podriamos quitarlo
         * lo dejare de cara a futuras ampliaciones
         */
        return ProyectoResource::collection(
            Proyecto::orderBy($request->_sort ?? 'id', $request->_order ?? 'asc')
            ->paginate($request->perPage)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Proyecto::class);
        $proyecto = json_decode($request->getContent(), true);
        if (!$request->user()->esAdmin()) {
            $proyecto['docente_id'] = $request->user()->id;
        }
        $proyecto = Proyecto::create($proyecto);

        return new ProyectoResource($proyecto);
    }

    /**
     * Display the specified resource.
     */
    public function show(Proyecto $proyecto)
    {
            return new ProyectoResource($proyecto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proyecto $proyecto)
    {
        Gate::authorize('update', Proyecto::class);

        $proyectoData = json_decode($request->getContent(), true);
        $proyecto->update($proyectoData);

        return new ProyectoResource($proyecto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proyecto $proyecto)
    {
        Gate::authorize('delete', Proyecto::class);

        try {
            $proyecto->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
}
