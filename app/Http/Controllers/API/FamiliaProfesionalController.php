<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FamiliaProfesionalResource;
use App\Models\FamiliaProfesional;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class FamiliaProfesionalController extends Controller implements HasMiddleware
{
    public $modelclass = FamiliaProfesional::class;

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
        $query = $request->attributes->has('queryWithParameters')
            ? $request->attributes->get('queryWithParameters')
            : FamiliaProfesional::query();
        return FamiliaProfesionalResource::collection($query->paginate($request->perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', FamiliaProfesional::class);
        if ($request->user()->esAdmin()) {
            $familiaProfesional = json_decode($request->getContent(), true);

            $familiaProfesional = FamiliaProfesional::create($familiaProfesional);

            return new FamiliaProfesionalResource(($familiaProfesional));
        } else
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    /**
     * Display the specified resource.
     */
    public function show(FamiliaProfesional $familiaProfesional)
    {
        return new FamiliaProfesionalResource($familiaProfesional);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FamiliaProfesional $familiaProfesional)
    {
        Gate::authorize('update', $familiaProfesional);
        if ($request->user()->esAdmin()) {
            $familiaProfesionalData = json_decode($request->getContent(), true);
            $familiaProfesional->update($familiaProfesionalData);
            return new FamiliaProfesionalResource($familiaProfesional);
        }
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FamiliaProfesional $familiaProfesional)
    {
        Gate::authorize('delete', $familiaProfesional);
        try {
            $familiaProfesional->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 403);
        }
    }
}
