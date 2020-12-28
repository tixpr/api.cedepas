<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
		$roles = [];
		foreach($this->roles as $role){
			array_push($roles,$role->name);
		};
        return [
			'id'=>$this->id,
			'firstname'=>$this->firstname,
			'lastname'=>$this->lastname,
			'email'=>$this->email,
			'roles'=>$roles
		];
    }
}
