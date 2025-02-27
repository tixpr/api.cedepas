<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Resources\CourseResource;
use App\Models\Area;

class CourseController extends Controller
{
	public function postCourse(Request $request, $area_id)
	{
		Area::findOrFail($area_id);
		$course = Course::create([
			'name' => $request->name,
			'credits' => $request->credits,
			'hours' => $request->hours,
			'code'	=>	$request->code,
			'program' => $request->program,
			'area_id' => $area_id
		]);
		return new CourseResource($course);
	}
	public function putCourse(Request $request, $course_id)
	{
		$course = Course::findOrFail($course_id);
		$course->name = $request->name;
		$course->credits = $request->credits;
		$course->hours = $request->hours;
		$course->code = $request->code;
		$course->program = $request->program;
		$course->save();
		return new CourseResource($course);
	}
	public function deleteCourse(Request $request, $course_id)
	{
		$course = Course::findOrFail($course_id);
		$course->delete();
		return response()->json([]);
	}
}
