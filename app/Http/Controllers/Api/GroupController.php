<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Http\Resources\GroupResource;
use App\Http\Resources\CourseGroupResource;
use App\Models\CourseGroup;

class GroupController extends Controller
{
	public function getGroups()
	{
		return GroupResource::collection(Group::orderBy('id', 'desc')->paginate(20));
	}
	public function postGroups(Request $request)
	{
		$group = Group::create([
			'name' => $request->name,
			'start' => $request->start,
			'end' => $request->end,
			'pre_register_enabled' => true
		]);
		return new GroupResource($group);
	}
	public function putGroup(Request $request, $group_id)
	{
		$group = Group::findOrFail($group_id);
		$group->name = $request->name;
		$group->start = $request->start;
		$group->end = $request->end;
		$group->pre_register_enabled = $request->pre_register_enabled;
		$group->save();
		return new GroupResource($group);
	}
	public function deleteGroup(Request $request, $group_id)
	{
		$group = Group::findOrFail($group_id);
		$group->delete();
		return response()->json([]);
	}
	public function getGroup(Request $request, $group_id)
	{
		$courses_group = CourseGroup::orderBy('id', 'desc')->where('group_id', $group_id)->get();
		return CourseGroupResource::collection($courses_group);
	}

	public function postGroup(Request $request, $group_id)
	{
		$course_group = CourseGroup::create([
			'course_id' => $request->course_id,
			'group_id' => $group_id,
			'user_id' => $request->user_id
		]);
		return new CourseGroupResource($course_group);
	}
}
