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
		Group::factory(10)->create();
		$groups = Group::orderBy('id','asc')->get();
		$acum=1;
		foreach($groups as $group){
			$group->courses()->attach($acum,['user_id'=>random_int(2,9)]);
			++$acum;
			$group->courses()->attach($acum,['user_id'=>random_int(2,9)]);
			++$acum;
			$group->courses()->attach($acum,['user_id'=>random_int(2,9)]);
			++$acum;
			$group->courses()->attach($acum,['user_id'=>random_int(2,9)]);
			++$acum;
		}
    }
}
