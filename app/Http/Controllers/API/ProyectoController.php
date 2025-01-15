<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProyectoResource;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            return ProyectoResource::collection(
                Proyecto::orderBy($request->_sort ?? 'id', $request->_order ?? 'asc')
                ->paginate($request->perPage)
            );

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $proyectoData = json_decode($request->getContent(), true);
            $proyecto = Proyecto::create($proyectoData);

            return new ProyectoResource($proyecto);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Proyecto $proyecto)
    {
        try {
            return new ProyectoResource($proyecto);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proyecto $proyecto)
    {
        try {
            $proyectoData = json_decode($request->getContent(), true);
            $proyecto->update($proyectoData);

            return new ProyectoResource($proyecto);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proyecto $proyecto)
    {
        try {
            $proyecto->delete();

            return response()->json([
                'message' => 'Proyecto eliminado correctamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error' . $e->getMessage()
            ], 400);
        }
    }
}
