<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (!is_null($request->user())) {
			if ($request->user()->level == 1) {
				return $next($request);
			}
		}
		return redirect('/admin/dang-nhap');
	}
}
