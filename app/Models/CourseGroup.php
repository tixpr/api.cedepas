<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseGroup extends Model
{
	use HasFactory;
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'course_group';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'course_id',
		'group_id'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [];
	public function teacher()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function course()
	{
		return $this->belongsTo(Course::class, 'course_id');
	}

	public function students()
	{
		return $this->belongsToMany(User::class, 'students', 'course_group_id', 'user_id');
	}
	public function matriculas()
	{
		return $this->belongsToMany(User::class, 'matriculas', 'course_group_id', 'user_id');
	}
	public function student_pagos()
	{
		return $this->belongsToMany(User::class, 'student_pagos', 'course_group_id', 'user_id');
	}
	public function notes()
	{
		return $this->hasMany(Note::class, 'course_group_id', 'id');
	}
	
	public function presences()
	{
		return $this->hasMany(Presence::class, 'course_group_id', 'id');
	}
}
