<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
	use HasFactory;
	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'courses';

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
		'user_id',
		'group_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
	];
	public function students()
	{
		return $this->belongsToMany(User::class, 'students', 'course_id', 'user_id');
	}
	public function notes()
	{
		return $this->hasMany(Note::class, 'course_id', 'id');
	}
	public function presences()
	{
		return $this->hasMany(Presence::class, 'course_id', 'id');
	}
	public function teacher()
	{
		return $this->belongsTo(User::class);
	}

}
