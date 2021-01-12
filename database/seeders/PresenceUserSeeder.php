<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresenceUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inicio = 11;
		$inc = 0;
		$presence_id = 1;
		for($i=1;$i<=60;$i++){
			while($inc<21){
				DB::table('presence_user')->insert([
					'presence' => random_int(0,1),
					'user_id'=>$inicio+$inc,
					'presence_id' => $presence_id
				]);
				DB::table('presence_user')->insert([
					'presence' => random_int(0,1),
					'user_id'=>$inicio+$inc,
					'presence_id' => $presence_id+1
				]);
				DB::table('presence_user')->insert([
					'presence' => random_int(0,1),
					'user_id'=>$inicio+$inc,
					'presence_id' => $presence_id+2
				]);
				++$inc;
			}
			$inicio+=$inc;
			$inc=0;
			$presence_id+=3;
		}
    }
}
