<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\GroupResource;
use App\Http\Resources\CourseGroupResource;
use App\Http\Resources\NoteUserResource;
use App\Http\Resources\NoteViewResource;
use App\Http\Resources\PresenceUserResource;
use App\Http\Resources\PresenceViewResource;
use App\Http\Resources\StudentCourseGroupResource;
use App\Http\Resources\StudentResource;
use App\Models\CourseGroup;
use App\Models\Group;
use App\Models\NoteUser;
use App\Models\PresenceUser;

class StudentController extends Controller
{
	public function getGroups(Request $request)
	{
		$user = $request->user();
		$courses_group = $user->studentCoursesGroup;
		$ids = [];
		foreach ($courses_group as $course_group) {
			if (!in_array($course_group->group_id, $ids)) {
				array_push($ids, $course_group->group_id);
			}
		}
		$groups = Group::orderBy('id', 'desc')->whereIn('id', $ids)->get();
		return GroupResource::collection($groups);
	}
	public function getCoursesGroup(Request $request, $group_id)
	{
		$user = $request->user();
		$courses_group = $user->studentCoursesGroup($group_id)->get();
		return CourseGroupResource::collection($courses_group);
	}
	public function getCourseGroup(Request $request, $course_group_id)
	{
		$course_group = CourseGroup::findOrFail($course_group_id);
		$notes = $course_group->notes;
		$presences = $course_group->presences;
		$n_ids = [];
		$p_ids = [];
		foreach ($notes as $note) {
			if (!in_array($note->id, $n_ids)) {
				array_push($n_ids, $note->id);
			}
		}
		foreach ($presences as $presence) {
			if (!in_array($presence->id, $p_ids)) {
				array_push($p_ids, $presence->id);
			}
		}
		$user = $request->user();
		$user_notes = NoteUser::whereIn('note_id', $n_ids)->where('user_id', $user->id)->get();
		$user_presences = PresenceUser::whereIn('presence_id', $p_ids)->where('user_id', $user->id)->get();
		return response()->json([
			'data' => [
				'course' => new StudentCourseGroupResource($course_group),
				'teacher' => new StudentResource($course_group->teacher),
				'notes' => NoteViewResource::collection($notes),
				'presences' => PresenceViewResource::collection($presences),
				'user_notes' => NoteUserResource::collection($user_notes),
				'user_presences' => PresenceUserResource::collection($user_presences)
			]
		]);
	}
}
