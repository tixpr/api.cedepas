<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//use Illuminate\Support\Facades\DB;

class CreateRolesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Schema::defaultStringLength(191);
		Schema::create('roles', function (Blueprint $table) {
			$table->id();
			$table->string('name', 20);
		});
		Schema::create('role_user', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')
				->constrained('users')
				->onUpdate('cascade')
				->onDelete('cascade');
			$table->foreignId('role_id')
				->constrained('roles')
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
		//Schema::disableForeignKeyConstraints();
		Schema::dropIfExists('roles');
		Schema::dropIfExists('user_roles');
		//Schema::enableForeignKeyConstraints();
	}
}
