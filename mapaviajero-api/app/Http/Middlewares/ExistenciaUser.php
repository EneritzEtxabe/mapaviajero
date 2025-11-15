<?php

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;

class ExistenciaUser
{
    public function handle(Request $request, Closure $next)
    {
        {
            $user = $request->user();

            if (!$user) {
                $user->tokens()->delete();
                return response()->json([
                    'message' => 'Usuario no encontrado. Sesión cerrada.'
                ], 401);
            }

            return $next($request);
        }
    }
}