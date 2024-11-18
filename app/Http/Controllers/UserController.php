<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Mostrar información de un usuario.
     * @param  string  $nombre
     * @return Response
     */
    public function showProfile($nombre)
    {
        return view('user.profile', ['user' => $nombre]);
    }
}
