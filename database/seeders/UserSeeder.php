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
		$u = User::create([
			'firstname' => mb_strtoupper('Adderlyn Tito'),
			'lastname' => mb_strtoupper('Palacios Rojas'),
			'email' => 'tixpr7@gmail.com',
			'cell_phone' => '954923400',
			'password' => bcrypt('password'),
			'email_verified_at' => now(),
			'created_at' => now(),
			'updated_at' => now(),
			'remember_token' => Str::random(10),
		]);
		$u->roles()->attach(1);
		$u->roles()->attach(2);
		$u->roles()->attach(3);
		User::factory(2000)->create();
		$teachers = User::whereIn('id', [2, 3, 4, 5, 6, 7, 8, 9])->get();
		foreach ($teachers as $teacher) {
			$teacher->roles()->attach(3);
		}
		$students = User::where('id', '>', 10)->get();
		foreach ($students as $student) {
			$student->roles()->attach(2);
		}
	}
}
