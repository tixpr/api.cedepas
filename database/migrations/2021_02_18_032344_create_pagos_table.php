<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pagos', function (Blueprint $table) {
			$table->id();
			$table->unsignedInteger('mont');
			$table->boolean('approved')->default(false);
			$table->string('vaucher');
			$table->foreignId('student_pago_id')
				->constrained('student_pagos')
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
		Schema::dropIfExists('pagos');
	}
}
