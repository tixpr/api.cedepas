<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\StudentPago;
use App\Models\CourseGroup;

class PagosController extends Controller
{
	public function getPagos(Request $request, $course_group_id)
	{
		$cg = CourseGroup::findOrFail($course_group_id);
		$students_pagos = $cg->student_pagos()->select('users.id', 'users.firstname', 'users.lastname', 'users.active', 'student_pagos.cost', 'student_pagos.id as student_pago_id')->get();
		$ids = [];
		foreach ($students_pagos as $st) {
			array_push($ids, $st->student_pago_id);
		}
		$pagos = Pago::whereIn('student_pago_id', $ids)->get();
		return response()->json([
			'students' => $students_pagos,
			'pagos' => $pagos,
		]);
	}
	public function putStudentPago(Request $request, $student_pago_id)
	{
		$sp = StudentPago::findOrFail($student_pago_id);
		$sp->cost = $request->cost;
		$sp->save();
		return response()->json([
			'cost' => $request->cost,
		]);
	}

	public function putPago(Request $request, $pago_id)
	{
		$p = Pago::findOrFail($pago_id);
		$p->approved = !$p->approved;
		$p->save();
		return response()->json([
			'approved' => $p->approved
		]);
	}
	public function deletePago(Request $request, $pago_id)
	{
		$p = Pago::findOrFail($pago_id);
		$p->delete();
		return response()->json([]);
	}
}
