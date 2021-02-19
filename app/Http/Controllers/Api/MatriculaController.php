<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseGroup;
use App\Models\Note;
use App\Models\Presence;
use App\Http\Resources\StudentResource;
//prueba
use Illuminate\Support\Facades\Log;

class MatriculaController extends Controller
{
	public function getMatriculaStudent(Request $request, $course_group_id)
	{
		$cg = CourseGroup::findOrFail($course_group_id);
		$students = $cg->matriculas;
		return StudentResource::collection($students);
	}
	public function postMatriculaStudent(Request $request, $course_group_id)
	{
		$cg = CourseGroup::findOrFail($course_group_id);
		$students = $cg->matriculas;
		$students2 = $cg->matriculas()->select('users.id')->get();
		/*
		Log::info(gettype($students));
		Log::info($students);
		Log::info(gettype($students2));
		Log::info($students2);
		*/
		//codigo para agregar datos de ejemplo al matricular
		$note1 = Note::create([
			'name' => 'N1',
			'course_group_id' => $cg->id
		]);
		$note2 = Note::create([
			'name' => 'N2',
			'course_group_id' => $cg->id
		]);
		$note3 = Note::create([
			'name' => 'N3',
			'course_group_id' => $cg->id
		]);
		$presence1 = Presence::create([
			'date' => now(),
			'course_group_id' => $cg->id
		]);
		$presence2 = Presence::create([
			'date' => now(),
			'course_group_id' => $cg->id
		]);
		$presence3 = Presence::create([
			'date' => now(),
			'course_group_id' => $cg->id
		]);
		foreach ($students as $student) {
			$cg->students()->attach($student->id);
			$note1->students()->attach($student->id, ['note' => random_int(11, 20)]);
			$note2->students()->attach($student->id, ['note' => random_int(11, 20)]);
			$note3->students()->attach($student->id, ['note' => random_int(11, 20)]);
			$presence1->students()->attach($student->id, ['presence' => random_int(0, 1)]);
			$presence2->students()->attach($student->id, ['presence' => random_int(0, 1)]);
			$presence3->students()->attach($student->id, ['presence' => random_int(0, 1)]);
			$cg->matriculas()->detach($student->id);
		}
		return response()->json([]);
	}
	public function deleteMatriculaStudent(Request $request, $course_group_id, $user_id)
	{
		$cg = CourseGroup::findOrFail($course_group_id);
		$cg->matriculas()->detach($user_id);
		return response()->json([]);
	}
}
