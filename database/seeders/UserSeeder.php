<?php

namespace Database\Seeders;

//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\GlobalVar;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		GlobalVar::create([
			'name' => 'register',
			'value_boolean' => true
		]);
		$admin = User::create([
			'firstname' => 'Administrador',
			'lastname' => 'CEDEPAS',
			'email' => 'cedepas.webapp@gmail.com',
			'password' => bcrypt('c3d3p@sc3ntr0'),
			'email_verified_at' => now(),
			'created_at' => now(),
			'updated_at' => now(),
		]);
		//$admin->roles()->attach(1);
		//$admin->roles()->attach(2);
		$admin->roles()->attach(3);
		//2-10
		/*
		for ($i = 2; $i <= 10; $i++) {
			$n = $i - 1;
			$teacher = User::create([
				'firstname' => 'Docente' . $n,
				'lastname' => 'Apellido Docente' . $n,
				'email' => 'docente' . $n . '@gmail.com',
				'password' => bcrypt('contraseña'),
				'email_verified_at' => now(),
				'created_at' => now(),
				'updated_at' => now(),
			]);
			$teacher->roles()->attach(2);
		}
		*/
		//11-211
		/*
		for ($j = 11; $j <= 150; $j++) {
			$n = $j - 10;
			$student = User::create([
				'firstname' => 'Estudiante' . $n,
				'lastname' => 'Apellido Estudiante' . $n,
				'email' => 'estudiante' . $n . '@gmail.com',
				'password' => bcrypt('contraseña'),
				'email_verified_at' => now(),
				'created_at' => now(),
				'updated_at' => now(),
				'remember_token' => Str::random(10),
			]);
			$student->roles()->attach(1);
		}
		*/
		//User::factory(1500)->create();
	}
}
