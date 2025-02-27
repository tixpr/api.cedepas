<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
	use HasFactory;
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'notes';

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
		'name',
		'is_end',
		'course_group_id'
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
	public function studentNotes()
	{
		return $this->hasMany(NoteUser::class, 'note_id');
	}
	public function students()
	{
		return $this->belongsToMany(User::class, 'note_user', 'note_id', 'user_id');
	}
}
