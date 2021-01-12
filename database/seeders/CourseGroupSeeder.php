<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseGroupSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		for ($i = 1; $i <= 20; $i++) {
			DB::table('course_group')->insert([
				'course_id' => random_int(1, 40),
				'user_id'	=> random_int(1,9),
				'group_id' => $i
			]);
			DB::table('course_group')->insert([
				'course_id' => random_int(1, 40),
				'user_id'	=> random_int(1,9),
				'group_id' => $i
			]);
			DB::table('course_group')->insert([
				'course_id' => random_int(1, 40),
				'user_id'	=> random_int(1,9),
				'group_id' => $i
			]);
		}
	}
}
