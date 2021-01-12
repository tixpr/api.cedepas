<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NoteUserSeeder extends Seeder
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
		$note_id = 1;
		for($i=1;$i<=60;$i++){
			while($inc<21){
				DB::table('note_user')->insert([
					'note' => random_int(10,20),
					'user_id'=>$inicio+$inc,
					'note_id' => $note_id
				]);
				DB::table('note_user')->insert([
					'note' => random_int(10,20),
					'user_id'=>$inicio+$inc,
					'note_id' => $note_id+1
				]);
				DB::table('note_user')->insert([
					'note' => random_int(10,20),
					'user_id'=>$inicio+$inc,
					'note_id' => $note_id+2
				]);
				++$inc;
			}
			$inicio+=$inc;
			$inc=0;
			$note_id+=3;
		}
    }
}
