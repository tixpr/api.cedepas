<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\CourseGroup;
use Illuminate\Http\Request;
use App\Http\Resources\TeacherResource;
use App\Http\Resources\CourseInfoResource;
use App\Http\Resources\CourseGroupResource;
use App\Http\Resources\CourseGroupViewResource;
use App\Models\Course;
use App\Models\Role;

class CourseGroupController extends Controller
{
	public function getCoursesTeachers(Request $request, $group_id)
	{
		$group = Group::findOrFail($group_id);
		$courses = $group->courses;
		$ids = [];
		foreach ($courses as $course) {
			array_push($ids, $course->id);
		}
		$courses_not = Course::whereNotIn('id', $ids)->orderBy('id', 'desc')->get();
		$teachers = Role::findOrFail(2)->users;
		return response()->json([
			'data' => [
				'courses' => CourseInfoResource::collection($courses_not),
				'teachers' => TeacherResource::collection($teachers)
			]
		]);
	}
	public function getCourseGroup(Request $request, $course_group_id)
	{
		$course_group = CourseGroup::findOrFail($course_group_id);
		return new CourseGroupViewResource($course_group);
	}
	public function putCourseGroup(Request $request, $course_group_id)
	{
		$cg = CourseGroup::findOrFail($course_group_id);
		$cg->user_id = $request->user_id;
		$cg->save();
		return new CourseGroupResource($cg);
	}
	public function deleteCourseGroup(Request $request, $course_group_id)
	{
		$cg = CourseGroup::findOrFail($course_group_id);
		$cg->delete();
		return response()->json([]);
	}
}
