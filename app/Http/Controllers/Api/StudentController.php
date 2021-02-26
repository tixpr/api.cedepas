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
use App\Http\Requests\Student\UploadVaucherRequest;
use App\Models\CourseGroup;
use App\Models\Group;
use App\Models\NoteUser;
use App\Models\PresenceUser;
use App\Models\StudentPago;
use App\Models\Pago;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CourseGroupRegisterResource;
use App\Models\Matricula;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDOException;

class StudentController extends Controller
{
	public function getGroups(Request $request)
	{
		$user = $request->user();
		$cgs = $user->studentCoursesGroup()->distinct()->get();
		$ids = [];
		foreach ($cgs as $cg) {
			if (!in_array($cg->group_id, $ids)) {
				array_push($ids, $cg->group_id);
			}
		}
		$groups = Group::orderBy('id', 'desc')->whereIn('id', $ids)->get();
		return GroupResource::collection($groups);
	}
	public function getCoursesGroup(Request $request, $group_id)
	{
		Group::findOrFail($group_id);
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
	public function getPagos(Request $request, $course_group_id)
	{
		CourseGroup::findOrFail($course_group_id);
		$user = $request->user();
		$st_p = StudentPago::where('user_id', $user->id)->where('course_group_id', $course_group_id)->firstOrFail();
		$pagos = $st_p->pagos()->orderBy('pagos.id', 'desc')->get();
		return response()->json([
			'cost' => $st_p->cost,
			'pagos' => $pagos,
		]);
	}
	public function postVaucher(UploadVaucherRequest $request)
	{
		$user = $request->user();
		$vaucher = $request->file('vaucher');
		$extension = $vaucher->extension();
		$filename = $user->id . '.' . $extension;
		if (Storage::disk('local')->exists("vauchers/" . $filename)) {
			Storage::disk('local')->delete('vauchers/' . $filename);
		}
		$path = $vaucher->storeAs(
			'vauchers',
			$filename,
			'local'
		);
		return response()->json([
			'filename' => $path,
		]);
	}
	public function postPagos(Request $request, $course_group_id)
	{
		$user = $request->user();
		CourseGroup::findOrFail($course_group_id);
		$st_p = StudentPago::where('user_id', $user->id)->where('course_group_id', $course_group_id)->firstOrFail();
		$ext = pathinfo(storage_path('/' . $request->vaucher), PATHINFO_EXTENSION);
		$pago = null;
		DB::beginTransaction();
		try {
			$pago = Pago::create([
				'mont' => $request->mont,
				'approved' => false,
				//'vaucher' => secure_url('/storage/vauchers/v1.png')
				'vaucher' => 'temp',
				'student_pago_id' => $st_p->id,
			]);
			$nname = $pago->id . '.' . $ext;
			$pago->vaucher = $nname;
			$pago->save();
			Storage::disk('local')->move('/' . $request->vaucher, '/public/vauchers/' . $nname);
			DB::commit();
		} catch (Exception $e) {
			DB::rollBack();
			if ($request->wantsJson()) {
				return response()->json([
					'message' => 'Error en la transacción'
				], 500);
			}
			throw $e;
		}
		return response()->json([
			'pago' => $pago,
		]);
	}
	public function getGroupsRegister()
	{
		$groups = Group::where('pre_register_enabled', true)->orderBy('id', 'desc')->get();
		return GroupResource::collection($groups);
	}
	public function getCoursesGroupRegister(Request $request, $group_id)
	{
		$user = $request->user();
		$group = Group::findOrFail($group_id);
		$matriculas = Matricula::where('user_id', $user->id)->get();
		$ids = [];
		foreach ($matriculas as $matricula) {
			array_push($ids, $matricula->course_group_id);
		}
		$courses = $group->courses()->select('course_group.id as id', 'courses.name')
			->whereNotIn('course_group.id', $ids)->get();
		return CourseGroupRegisterResource::collection($courses);
	}
	public function postPreRegister(Request $request, $course_group_id)
	{
		$user = $request->user();
		CourseGroup::findOrFail($course_group_id);
		Matricula::create([
			'user_id' => $user->id,
			'course_group_id' => $course_group_id,
		]);
		return response()->json();
	}
}
