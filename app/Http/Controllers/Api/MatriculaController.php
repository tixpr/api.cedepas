<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseGroup;
use App\Http\Resources\StudentResource;
//prueba
use Illuminate\Support\Facades\DB;
use App\Models\StudentPago;
use PDOException;

class MatriculaController extends Controller
{
	public function getMatriculaStudent(Request $request, $course_group_id)
	{
		$cg = CourseGroup::findOrFail($course_group_id);
		$students = $cg->matriculas;
		return StudentResource::collection($students);
	}
	public function postMatriculaStudent(Request $request, $course_group_id)
	{
		$cg = CourseGroup::findOrFail($course_group_id);
		DB::beginTransaction();
		try {
			$students = $cg->matriculas()->select('users.id')->get();
			$students_keys = $students->modelKeys();
			foreach ($students_keys as $key) {
				$cg->students()->attach($key);
				StudentPago::create([
					'course_group_id' => $course_group_id,
					'user_id' => $key,
					'cost' => 100
				]);
				$cg->matriculas()->detach($key);
			}
			DB::commit();
		} catch (PDOException $e) {
			DB::rollBack();
			if ($request->wantsJson()) {
				return response()->json([
					'message' => 'Error en la transacción'
				], 500);
			}
			throw $e;
		}
		return response()->json([]);
	}
	public function deleteMatriculaStudent(Request $request, $course_group_id, $user_id)
	{
		$cg = CourseGroup::findOrFail($course_group_id);
		$cg->matriculas()->detach($user_id);
		return response()->json([]);
	}
}
