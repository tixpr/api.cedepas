<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
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
		$teacher = $user->roles()->where('roles.name', "Administrador")->first();
		if ($user and $teacher) {
			return $next($request);
		}
		return response()->json([
			'message' => 'No cuenta con los credenciales para acceder'
		], 403);
	}
}
