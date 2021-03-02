<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\DB;
use App\Models\CourseGroup;
use App\Models\Note;
use App\Models\Presence;
use App\Models\StudentPago;
use App\Models\Pago;

class StudentSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/*
		$id = 1;
		$inicio = 10;
		$final = $inicio + 21;
		do {
			$ids = [$id, $id + 1, $id + 2, $id + 3, $id + 4];
			$cgroups = CourseGroup::whereIn('id', $ids)->get();
			foreach ($cgroups as $cg) {
				//NUEVO
				$note1 = Note::create([
					'name' => 'N1',
					'course_group_id' => $cg->id
				]);
				$note2 = Note::create([
					'name' => 'N2',
					'course_group_id' => $cg->id
				]);
				$note3 = Note::create([
					'name' => 'N3',
					'is_end' => true,
					'course_group_id' => $cg->id
				]);
				$presence1 = Presence::create([
					'date' => now(),
					'course_group_id' => $cg->id
				]);
				$presence2 = Presence::create([
					'date' => now(),
					'course_group_id' => $cg->id
				]);
				$presence3 = Presence::create([
					'date' => now(),
					'course_group_id' => $cg->id
				]);
				//==================================================
				for ($i = $inicio; $i <= $final; $i++) {
					//PARA MATRICULAS
					//$cg->matriculas()->attach($i);
					//NUEVO
					$cg->students()->attach($i);
					$stpg = StudentPago::create([
						'course_group_id' => $cg->id,
						'user_id' => $i,
						'cost' => 100
					]);
					$pagos = random_int(1, 3);
					for ($j = 0; $j <= $pagos; $j++) {
						Pago::create([
							'student_pago_id' => $stpg->id,
							'mont' => random_int(1, 20),
							'approved' => random_int(0, 1),
							//'vaucher' => secure_url('/storage/vauchers/v1.png')
							'vaucher' => 'v1.png'
						]);
					}
					$note1->students()->attach($i, ['note' => random_int(11, 20)]);
					$note2->students()->attach($i, ['note' => random_int(11, 20)]);
					$note3->students()->attach($i, ['note' => random_int(11, 20)]);
					$presence1->students()->attach($i, ['presence' => random_int(0, 1)]);
					$presence2->students()->attach($i, ['presence' => random_int(0, 1)]);
					$presence3->students()->attach($i, ['presence' => random_int(0, 1)]);
					//$cg->matriculas()->detach($i);
					//==========================================
				}
			}
			$inicio = $final + 1;
			$final += 21;
			$id += 5;
		} while ($id < 25);
		*/
	}
}
