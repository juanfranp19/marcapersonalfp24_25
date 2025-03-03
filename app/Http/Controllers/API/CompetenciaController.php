<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompetenciaResource;
use App\Models\Competencia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class CompetenciaController extends Controller implements HasMiddleware
{
    public $modelclass = Competencia::class;
    /**
     * Display a listing of the resource.
     */

     public static function middleware(): array
     {
         return [
             new Middleware('auth:sanctum', except: ['index', 'show']),
         ];
     }

    public function index(Request $request)
    {
        return CompetenciaResource::collection(
            Competencia::orderBy($request->_sort ?? 'id', $request->_order ?? 'asc')
            ->paginate($request->perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Competencia::class);

        $competencia = json_decode($request->getContent(), true);

        $ciclo = Competencia::create($competencia);

        return new CompetenciaResource($ciclo);
    }

    /**
     * Display the specified resource.
     */
    public function show(Competencia $competencia)
    {
        return new CompetenciaResource($competencia);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Competencia $competencia)
    {
        Gate::authorize('update', $competencia);

        $competenciaData = json_decode($request->getContent(), true);
        $competencia->update($competenciaData);

        return new CompetenciaResource($competencia);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Competencia $competencia)
    {
        Gate::authorize('delete', $competencia);
        
        try {
            $competencia->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()], 400);
        }
    }
    }

