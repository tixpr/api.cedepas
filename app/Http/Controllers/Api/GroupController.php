<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    public function getGroups()
	{
		return response()->json(Group::orderBy('id','desc')->paginate(20));
	}
	public function postGroup(Request $request)
	{
		$group = new Group();
		$group->name = mb_strtoupper($request->name);
		$group->save();
		return response()->json([
			'data'=>$group
		]);
	}
	public function putGroup(Request $request,$group_id)
	{
		$group = Group::findOrFail($group_id);
		$group->name = mb_strtoupper($request->name);
		$group->save();
		return response()->json([
			'data'=>$group
		]);
	}
	public function deleteGroup(Request $request,$group_id)
	{
		$group = Group::findOrFail($group_id);
		$group->delete();
		return response()->json([]);
	}
}
