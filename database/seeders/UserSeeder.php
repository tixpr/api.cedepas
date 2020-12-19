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
			'name' => mb_strtoupper('Adderlyn Tito Palacios Rojas'),
			'email' => 'tixpr7@gmail.com',
			'password' => bcrypt('password'),
			'email_verified_at' => now(),
			'created_at'=> now(),
			'updated_at'=> now(),
			'remember_token' => Str::random(10),
		]);
		$u->roles()->attach(1);
		$u->roles()->attach(2);
		$u->roles()->attach(3);
		User::factory(2000)->create();
		$users = User::where('id','>',1)->get();
		$roles = [[2],[3],[2,3]];
		foreach($users as $user){
			$r = random_int(0,2);
			foreach($roles[$r] as $rol){
				$user->roles()->attach($rol);
			}
		}
    }
}
