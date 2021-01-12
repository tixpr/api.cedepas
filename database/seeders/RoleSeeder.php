<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//1
        Role::create([
			'name'=>'Estudiante',
		]);
		//2
		Role::create([
			'name'=>'Docente',
		]);
		//3
		Role::create([
			'name'=>'Administrador',
		]);
		
    }
}
