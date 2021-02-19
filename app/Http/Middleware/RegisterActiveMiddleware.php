<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\GlobalVar;

class RegisterActiveMiddleware
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
		if (GlobalVar::where('name', 'register')->where('value_boolean', true)->first()) {
			return $next($request);
		}
		if ($request->wantsJson()) {
			return response()->json([
				'message' => "Error registro habilitado"
			], 403);
		}
		return redirect()->away(RouteServiceProvider::HOME);
	}
}
