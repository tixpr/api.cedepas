<?php

namespace Database\Seeders;

//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$admin = User::create([
			'firstname' => mb_strtoupper('Adderlyn Tito'),
			'lastname' => mb_strtoupper('Palacios Rojas'),
			'email' => 'tixpr7@gmail.com',
			'phone' => '954923400',
			'password' => bcrypt('password'),
			'email_verified_at' => now(),
			'created_at' => now(),
			'updated_at' => now(),
			'remember_token' => Str::random(10),
		]);
		$admin->roles()->attach(1);
		$admin->roles()->attach(2);
		$admin->roles()->attach(3);
		User::factory(1500)->create();
	}
}
