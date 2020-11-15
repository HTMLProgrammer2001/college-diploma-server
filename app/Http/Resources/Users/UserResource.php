<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fullName' => $this->fullName,
            'role' => $this->role,
            'avatar' => $this->getAvatar(),
            'birthday' => $this->birthday,
            'email' => $this->email,
            'address' => $this->address,
            'pedagogical_title' => $this->pedagogical_title,
            'experience' => $this->expirience,
            'rank' => $this->rank,
            'commission' => $this->commission,
            'department' => $this->department
        ];
    }
}
