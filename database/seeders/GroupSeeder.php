<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//Group::factory(10)->create();
		//$groups = Group::orderBy('id','asc')->get();
		for ($i = 1; $i <= 5; $i++) {
			$group = Group::create([
				'name' => 'Grupo ' . $i,
				'start' => now(),
				'end' => now()->addYear(),
				'pre_register_enabled' => true
			]);
			$group->courses()->attach(random_int(1, 18), ['user_id' => random_int(1, 9)]);
			$group->courses()->attach(random_int(19, 34), ['user_id' => random_int(1, 9)]);
			$group->courses()->attach(random_int(35, 36), ['user_id' => random_int(1, 9)]);
			$group->courses()->attach(random_int(37, 39), ['user_id' => random_int(1, 9)]);
			$group->courses()->attach(random_int(40, 46), ['user_id' => random_int(1, 9)]);
		}
	}
}
