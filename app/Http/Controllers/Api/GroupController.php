<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\http\Resources\GroupResource;
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
			'name' => mb_strtoupper($request->name)
		]);
		return new GroupResource($group);
	}
	public function putGroup(Request $request, $group_id)
	{
		$group = Group::findOrFail($group_id);
		$group->name = mb_strtoupper($request->name);
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
