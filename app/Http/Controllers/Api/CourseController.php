<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Resources\CourseResource;
use App\Http\Requests\ImportCoursesRequest;

class CourseController extends Controller
{
    public function getCourses(Request $request,$group_id)
	{
		$courses = Course::orderBy('id','desc')
							->where('group_id',$group_id)
							->get();
		return CourseResource::collection($courses);
	}
	public function postCourse(Request $request,$group_id)
	{
		$course = Course::create([
			'name'=>mb_strtoupper($request->name),
			'group_id'=>$group_id
		]);
		return response()->json([
			'data'=>$course
		]);
	}
	public function getCourse(Request $request,$course_id)
	{
		return response()->json(Course::findOrFail($course_id));
	}
	public function putCourse(Request $request,$course_id)
	{
		$course = Course::findOrFail($course_id);
		$course->name = mb_strtoupper($request->name);
		$course->save();
		return response()->json([
			'data'=>$course
		]);
	}
	public function deleteCourse(Request $request,$course_id)
	{
		Course::find($course_id)->delete();
		return response()->json([]);
	}
	public function postImportCourses(ImportCoursesRequest $request)
	{
		$file = $request->import_courses;
	}
}
