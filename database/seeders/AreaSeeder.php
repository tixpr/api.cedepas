<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Course;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Area::factory(4)
		->has(Course::factory()->count(10))
		->create();
    }
}
