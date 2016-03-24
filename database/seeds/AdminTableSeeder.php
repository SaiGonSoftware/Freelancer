<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class AdminTableSeeder extends Seeder {
	public function run() {
		\App\Admin::create([
			'name' => 'ngohungphuc',
			'password' => Hash::make('070695'),
		]
		);
	}
}