<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\DB;
use App\Models\CourseGroup;
use App\Models\Note;
use App\Models\Presence;

class StudentSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$id = 1;
		$inicio = 10;
		$final = $inicio + 21;
		do {
			$ids = [$id, $id + 1, $id + 2, $id + 3, $id + 4];
			$cgroups = CourseGroup::whereIn('id', $ids)->get();
			foreach ($cgroups as $cg) {
				for ($i = $inicio; $i <= $final; $i++) {
					$cg->matriculas()->attach($i);
				}
			}
			$inicio = $final + 1;
			$final += 21;
			$id += 5;
		} while ($id < 25);
	}
}
