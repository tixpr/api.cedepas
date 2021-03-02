<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseGroupRegisterResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		$teacher = $this->teacher()->firstOrFail();
		return [
			'id' => $this->id,
			'name' => $this->name,
			'teacher' =>  $teacher->firstname . ' ' . $teacher->lastname
		];
	}
}
