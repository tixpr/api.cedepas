<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
			$table->id();
			$table->string('name',120);
			$table->string('code',6)->unique();
			$table->string('program',4);
			$table->double('credits',2,1,true);
			$table->integer('hours',false,true);
			$table->foreignId('area_id')
				->constrained('areas')
				->onUpdate('cascade')
				->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
