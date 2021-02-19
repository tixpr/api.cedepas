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
use App\Models\User;

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
	public function getSearchStudent(Request $request, $course_group_id)
	{
		$cg = CourseGroup::findOrFail($course_group_id);
		$students = $cg->students;
		$stids = [];
		foreach ($students as $student) {
			array_push($stids, $student->id);
		}
		$student_role = Role::where('name', 'Estudiante')->firstOrFail();
		$get_students = User::orderBy('users.id', 'desc')->whereNotIn('users.id', $stids)->whereHas('roles', function ($query) use ($student_role) {
			return $query->where('role_id', $student_role->id);
		})->where('users.lastname', 'LIKE', "%{$request->search}%")->get();
		return TeacherResource::collection($get_students);
	}
	public function postStudent(Request $request, $course_group_id)
	{
		$user = User::findOrFail($request->user_id);
		$cg = CourseGroup::findOrFail($course_group_id);
		$cg->students()->attach($user->id);
		$notes = $cg->notes;
		$presences = $cg->presences;
		foreach ($notes as $note) {
			$note->students()->attach($user->id, ['note' => 0]);
		}
		foreach ($presences as $presence) {
			$presence->students()->attach($user->id, ['presence' => false]);
		}
		return new TeacherResource($user);
	}
}
