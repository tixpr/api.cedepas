<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		$this->call([
			BookSeeder::class,
			RoleSeeder::class,
			UserSeeder::class,
			AreaSeeder::class,
			CourseSeeder::class,
			GroupSeeder::class,
			StudentSeeder::class,
		]);
    }
}
