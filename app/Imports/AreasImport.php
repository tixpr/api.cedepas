<?php

namespace App\Imports;

use App\Models\Area;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AreasImport implements ToCollection
{
	public function collection(Collection $rows)
	{
		foreach ($rows as $row) {
			Area::create([
				'name' => $row[0]
			]);
		}
	}
}
