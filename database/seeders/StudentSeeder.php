<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
		$cgroups = CourseGroup::orderBy('id','asc')->get();
		$inicio = 10;
		$final = 30;
		foreach($cgroups as $cg){
			$note1 = Note::create([
				'name'=>'N1',
				'course_group_id'=>$cg->id
			]);
			$note2 = Note::create([
				'name'=>'N2',
				'course_group_id'=>$cg->id
			]);
			$note3 = Note::create([
				'name'=>'N3',
				'course_group_id'=>$cg->id
			]);
			$presence1 = Presence::create([
				'date'=>now(),
				'course_group_id'=>$cg->id
			]);
			$presence2 = Presence::create([
				'date'=>now(),
				'course_group_id'=>$cg->id
			]);
			$presence3 = Presence::create([
				'date'=>now(),
				'course_group_id'=>$cg->id
			]);
			for($i=$inicio;$i<=$final;$i++){
				$cg->students()->attach($i);
				$note1->students()->attach($i,['note'=>random_int(11,20)]);
				$note2->students()->attach($i,['note'=>random_int(11,20)]);
				$note3->students()->attach($i,['note'=>random_int(11,20)]);
				$presence1->students()->attach($i,['presence'=>random_int(0,1)]);
				$presence2->students()->attach($i,['presence'=>random_int(0,1)]);
				$presence3->students()->attach($i,['presence'=>random_int(0,1)]);
			}
			$inicio=$final+1;
			$final=$inicio+20;
		}
    }
}
