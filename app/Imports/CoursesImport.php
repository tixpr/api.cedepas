<?php

namespace App\Imports;

use App\Models\Course;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CoursesImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
			Course::create([
				'area_id' => $row[0],
				'code'	=>	$row[1],
				'program' => $row[2],
				'name' => $row[3],
				'hours' => $row[4],
				'credits' => $row[5],
			]);
		}
    }
}
