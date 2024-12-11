<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectosController extends Controller
{

    public function getIndex()
    {
        return view('proyectos.index')
            ->with('proyectos', Proyecto::all());
    }

    public function getShow($id)
    {
            return view('proyectos.show')
                ->with('proyecto', Proyecto::findOrfail($id))
                ->with('id', $id);
    }

    public function getCreate()
    {
        return view('proyectos.create');
    }

    public function getEdit($id)
    {
            return view('proyectos.edit')
                ->with('proyecto', Proyecto::findOrfail($id))
                ->with('id', $id);
    }



}
