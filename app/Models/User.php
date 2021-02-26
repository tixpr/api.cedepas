<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
	use HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'firstname',
		'lastname',
		'email',
		'phone',
		'active',
		'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	/**
	 * The roles that belong to the user.
	 */
	public function roles()
	{
		return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
	}
	//Docentes
	public function groups()
	{
		return $this->belongsToMany(Group::class, 'course_group', 'user_id', 'group_id')->distinct();
	}
	public function coursesGroup($group_id)
	{
		return $this->hasMany(CourseGroup::class, 'user_id')->where('course_group.group_id', $group_id);
	}
	//Estudiante
	public function studentCoursesGroup($group_id=null)
	{
		if($group_id==null){
			return $this->belongsToMany(CourseGroup::class, 'students', 'user_id', 'course_group_id');
		}
		return $this->belongsToMany(CourseGroup::class, 'students', 'user_id', 'course_group_id')->where('course_group.group_id',$group_id);
	}
	//notas
	public function notes()
	{
		return $this->belongsToMany(Note::class, 'note_user', 'user_id', 'note_id');
	}
	public function courses()
	{
		return $this->belongsToMany(Course::class, 'course_group', 'user_id', 'course_id');
	}
}
