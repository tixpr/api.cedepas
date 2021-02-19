<?php

namespace App\Imports;

use App\Models\Book;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BooksImport implements ToCollection
{
	public function collection(Collection $rows)
	{
		foreach ($rows as $row) {
			Book::create([
				'code' => $row[0],
				'author' => $row[1],
				'title_editor' => $row[2]
			]);
		}
	}
}
