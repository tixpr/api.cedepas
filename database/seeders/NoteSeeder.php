<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		for($i=1;$i<=60;$i++){
			DB::table('notes')->insert([
				'name' => 'N1',
				'course_group_id' => $i
			]);
			DB::table('notes')->insert([
				'name' => 'N2',
				'course_group_id' => $i
			]);
			DB::table('notes')->insert([
				'name' => 'N3',
				'course_group_id' => $i
			]);
		}
    }
}
