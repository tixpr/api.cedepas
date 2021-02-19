<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentCourseGroupResource extends JsonResource
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
			'id'=>$this->id,
			'name'=>$course->name,
			'credits'=>$course->credits,
			'hours'=>$course->hours,
		];
    }
}
