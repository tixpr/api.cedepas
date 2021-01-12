<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseGroupViewResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		$course = $this->course;
		return [
			'course' => [
				'id' => $this->id,
				'name' => $course->name,
				'credits' => $course->credits,
				'hours' => $course->hours,
			],
			'teacher' => new StudentResource($this->teacher),
			'students' => StudentResource::collection($this->students),
			'notes' => NoteResource::collection($this->notes),
			'presences' => PresenceResource::collection($this->presences)
		];
	}
}
