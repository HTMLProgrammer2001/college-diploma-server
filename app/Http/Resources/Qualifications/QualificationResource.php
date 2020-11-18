<?php

namespace App\Http\Resources\Qualifications;

use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class QualificationResource extends JsonResource
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
            'name' => $this->name,
            'date' => $this->date,
            'description' => $this->description,
            'user' => new UserResource($this->user)
        ];
    }
}
