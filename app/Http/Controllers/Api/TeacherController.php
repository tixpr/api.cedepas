<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\GroupResource;
use App\Http\Resources\CourseGroupResource;
use App\Http\Resources\CourseGroupViewResource;
use App\Http\Resources\NoteResource;
use App\Http\Resources\PresenceResource;
use App\Http\Resources\StudentNoteResource;
use App\Http\Resources\StudentPresenceResource;
use App\Models\CourseGroup;
use App\Models\Note;
use App\Models\NoteUser;
use App\Models\Presence;
use App\Models\PresenceUser;

class TeacherController extends Controller
{
	public function getGroups(Request $request)
	{
		$user = $request->user();
		$groups = $user->groups;
		return GroupResource::collection($groups);
	}
	public function getCoursesGroup(Request $request, $group_id)
	{
		$user = $request->user();
		$courses_group = $user->coursesGroup($group_id)->get();
		return CourseGroupResource::collection($courses_group);
	}
	public function getCourseGroup(Request $request, $course_group_id)
	{
		$user = $request->user();
		$course_group = CourseGroup::where('id', $course_group_id)->where('user_id', $user->id)->firstOrFail();
		return new CourseGroupViewResource($course_group);
	}
	public function postAddNote(Request $request, $course_group_id)
	{
		$course_group = CourseGroup::findOrFail($course_group_id);
		if ($request->is_end) {
			if (Note::where('course_group_id', $course_group_id)->where('is_end', true)->first()) {
				return response()->json([
					'message' => 'Nota final ya creada',
				], 403);
			}
		}
		$students = $course_group->students;
		$note = Note::create([
			'course_group_id' => $course_group_id,
			'name' => $request->name,
			'is_end' => $request->is_end,
		]);
		foreach ($students as $student) {
			NoteUser::create([
				'note' => $request->input('st_' . $student->id),
				'user_id' => $student->id,
				'note_id' => $note->id,
			]);
		}
		return new NoteResource($note);
	}
	public function postAddPresence(Request $request, $course_group_id)
	{
		$course_group = CourseGroup::findOrFail($course_group_id);
		$students = $course_group->students;
		$presence = Presence::create([
			'course_group_id' => $course_group_id,
			'date' => $request->date,
		]);
		foreach ($students as $student) {
			PresenceUser::create([
				'presence' => $request->input('st_' . $student->id),
				'user_id' => $student->id,
				'presence_id' => $presence->id,
			]);
		}
		return new PresenceResource($presence);
	}
	public function putUserNote(Request $request, $note_id, $user_id)
	{
		$note_user = NoteUser::where('note_id', $note_id)->where('user_id', $user_id)->firstOrFail();
		$note_user->note = $request->note;
		$note_user->save();
		return new StudentNoteResource($note_user);
	}
	public function putUserPresence(Request $request, $presence_id, $user_id)
	{
		$presence_user = PresenceUser::where('presence_id', $presence_id)->where('user_id', $user_id)->firstOrFail();
		$presence_user->presence = $request->presence;
		$presence_user->save();
		return new StudentPresenceResource($presence_user);
	}
	public function deleteUserNote(Request $request, $note_id)
	{
		$note = Note::findOrFail($note_id);
		$note->delete();
		return response()->json([]);
	}
	public function deleteUserPresence(Request $request, $presence_id)
	{
		$presence = Presence::findOrFail($presence_id);
		$presence->delete();
		return response()->json([]);
	}
}
