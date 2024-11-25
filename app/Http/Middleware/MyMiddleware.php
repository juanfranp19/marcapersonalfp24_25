<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $param1): Response
    {
        if ($request->route()->hasParameter('id') && $request->route()->parameter('id') > $param1) {
            return redirect('/');
        }

        $respuesta = $next($request);
        $respuesta->headers->set('Title', 'Proyectos');
        return $respuesta;
    }
}
