<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\App;

//use Illuminate\Support\Facades\Log;

class CertificadoController extends Controller
{
	public function getCertificado($user_id)
	{
		$user = User::findOrFail($user_id);
		$user->firstname = mb_strtoupper($user->firstname);
		$user->lastname = mb_strtoupper($user->lastname);
		$approved_notes = $user->notes()
			->where('note_user.note', '>', 13)
			->where('notes.is_end', true)
			->select(
				'note_user.note',
				'notes.course_group_id'
			)
			->get();
		$ids = [];
		$notes = [];
		$meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'setiembre', 'octubre', 'noviembre', 'diciembre'];
		$hoy = now();
		$creditos = 0;
		foreach ($approved_notes as $note) {
			array_push($ids, $note->course_group_id);
			$notes[$note->course_group_id] = $note->note;
		}
		$courses = Course::select('course_group.id as id', 'courses.code', 'courses.name', 'courses.credits')
			->leftJoin('course_group', 'courses.id', '=', 'course_group.course_id')
			->whereIn('course_group.id', $ids)
			->orderBy('courses.code', 'asc')
			->distinct()
			->get();
		foreach ($courses as $course) {
			$creditos += $course->credits;
		}
		$pdf = App::make('dompdf.wrapper');
		$pdf->loadView('certificado', ['courses' => $courses, 'notes' => $notes, 'total' => $creditos, 'user' => $user, 'hoy' => $hoy, 'meses' => $meses]);
		return $pdf->stream('certificado.pdf');
	}
	public function getStudentCertificado(Request $request)
	{
		$user = $request->user();
		$user->firstname = mb_strtoupper($user->firstname);
		$user->lastname = mb_strtoupper($user->lastname);
		$approved_notes = $user->notes()
			->where('note_user.note', '>', 13)
			->where('notes.is_end', true)
			->select(
				'note_user.note',
				'notes.course_group_id'
			)
			->get();
		$ids = [];
		$notes = [];
		$meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'setiembre', 'octubre', 'noviembre', 'diciembre'];
		$hoy = now();
		$creditos = 0;
		foreach ($approved_notes as $note) {
			array_push($ids, $note->course_group_id);
			$notes[$note->course_group_id] = $note->note;
		}
		$courses = Course::select('course_group.id as id', 'courses.code', 'courses.name', 'courses.credits')
			->leftJoin('course_group', 'courses.id', '=', 'course_group.course_id')
			->whereIn('course_group.id', $ids)
			->orderBy('courses.code', 'asc')
			->distinct()
			->get();
		foreach ($courses as $course) {
			$creditos += $course->credits;
		}
		$pdf = App::make('dompdf.wrapper');
		$pdf->loadView('certificado2', ['courses' => $courses, 'notes' => $notes, 'total' => $creditos, 'user' => $user, 'hoy' => $hoy, 'meses' => $meses]);
		return $pdf->stream('certificado.pdf');
	}
}
