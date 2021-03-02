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
			'message' => 'Usuario Inhabilitado debido a la falta de pago, favor de comunicarse con Consuelo Samaniego al 968047502, o con Lic. César Llanco Zavaleta al 997966407'
		], 403);
	}
}
