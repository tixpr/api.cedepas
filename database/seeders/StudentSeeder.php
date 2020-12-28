<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$courses = Course::all();
		$inicio=11;
		foreach($courses as $course){
			for($i=0;$i<32;$i++){
				Student::create([
					'course_id'	=>	$course->id,
					'user_id'	=>	($inicio+$i)
				]);
			}
			$inicio+=32;
		}
    }
}
