<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Imports\CoursesImport;
use Maatwebsite\Excel\Facades\Excel;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new CoursesImport,database_path('cursos.xlsx'));
    }
}
