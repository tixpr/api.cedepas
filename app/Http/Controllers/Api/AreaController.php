<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;
use App\Http\Resources\AreaResource;

class AreaController extends Controller
{
	public function getAreas(Request $request)
	{
		$areas = Area::orderBy('id', 'desc')->get();
		return AreaResource::collection($areas);
	}
	public function postArea(Request $request)
	{
		$area = Area::create([
			'name' => $request->name
		]);
		return new AreaResource($area);
	}
	public function putArea(Request $request, $area_id)
	{
		$area = Area::findOrFail($area_id);
		$area->name = $request->name;
		$area->save();
		return new AreaResource($area);
	}
	public function deleteArea(Request $request, $area_id)
	{
		$area = Area::findOrFail($area_id);
		$area->delete();
		return response()->json([]);
	}
}
