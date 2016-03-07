<?php namespace App\Providers;

use App\Chat;
use Auth;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		view()->composer('*', function ($view) {
			if (Auth::check()) {
				$total_mess = Chat::whereRaw('view = ?  and  to_user = ?', [0, Auth::user()->username])->count();
				$view->with('total_mess', $total_mess);
			}

			if (Auth::guest()) {
				$view->with('total_mess', '');
			}

		});
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register() {
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}