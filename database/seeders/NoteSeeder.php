<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Note;
use App\Models\NoteUser;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$pcs = Course::all();
		foreach($pcs as $pc){
			$note1 = Note::create([
				'name'=>'N1',
				'course_id'=>$pc->id
			]);
			$note2 = Note::create([
				'name'=>'N1',
				'course_id'=>$pc->id
			]);
			$note3 = Note::create([
				'name'=>'N1',
				'course_id'=>$pc->id
			]);
			$users = $pc->students;
			foreach($users as $user){
				NoteUser::create([
					'note'=>strval(random_int(0,20)),
					'note_id'=>$note1->id,
					'user_id'=>$user->id
				]);
				NoteUser::create([
					'note'=>strval(random_int(0,20)),
					'note_id'=>$note2->id,
					'user_id'=>$user->id
				]);
				NoteUser::create([
					'note'=>strval(random_int(0,20)),
					'note_id'=>$note3->id,
					'user_id'=>$user->id
				]);
			}
		}
    }
}
