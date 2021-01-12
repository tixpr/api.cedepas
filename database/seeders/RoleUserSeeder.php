<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RoleUserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//1=>estudiante
		//2=>docente
		//3=>administrador
		$others = User::orderBy('id','asc')->where('id','>',1)->get();
		$count = 2; 
		foreach($others as $other){
			if($count<10){
				$other->roles()->attach(2);
			}else{
				$other->roles()->attach(1);
			}
			++$count;
		}
	}
}
