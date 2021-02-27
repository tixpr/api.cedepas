<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserActiveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
		if ($user->active) {
			return $next($request);
		}
		return response()->json([
			'message' => 'Usuario Inhabilitado debido a la falta de pago, favor de comunicarse con los encargados'
		], 403);
    }
}
