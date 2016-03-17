<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		//Model::unguard();

		$this->call('user');
	}

}

class user extends Seeder {
	public function run() {
		DB::table('users')->insert([
			'id' => 4, 'username' => 'admin', 'password' => Hash::make(123456), 'level' => 1,'active'=>1
		]);
	}

}
