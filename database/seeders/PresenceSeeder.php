<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Presence;
use App\Models\Course;
use App\Models\PresenceUser;

class PresenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = Course::all();
		foreach($courses as $course){
			$presence1 = Presence::create([
				'date'=>now(),
				'course_id'=>$course->id
			]);
			$presence2 = Presence::create([
				'date'=>now(),
				'course_id'=>$course->id
			]);
			$presence3 = Presence::create([
				'date'=>now(),
				'course_id'=>$course->id
			]);
			$users = $course->students;
			foreach($users as $user){
				PresenceUser::create([
					'presence'=>random_int(0,1),
					'presence_id'=>$presence1->id,
					'user_id'=>$user->id
				]);
				PresenceUser::create([
					'presence'=>random_int(0,1),
					'presence_id'=>$presence2->id,
					'user_id'=>$user->id
				]);
				PresenceUser::create([
					'presence'=>random_int(0,1),
					'presence_id'=>$presence3->id,
					'user_id'=>$user->id
				]);
			}
		}
    }
}
