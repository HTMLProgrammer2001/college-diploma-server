<?php

namespace App\Http\Resources\Educations;

use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
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
            'institution' => $this->institution,
            'graduate_year' => $this->graduate_year,
            'qualification' => $this->qualification,
            'specialty' => $this->specialty,
            'user' => new UserResource($this->user)
        ];
    }
}
