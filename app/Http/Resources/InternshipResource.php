<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InternshipResource extends JsonResource
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
            'category' => new InternshipCategoryResource($this->category),
            'user' => new UserResource($this->user),
            'place' => $this->place,
            'title' => $this->title,
            'from' => $this->from,
            'to' => $this->to,
            'hours' => $this->hours,
            'credits' => $this->credits,
            'code' => $this->code
        ];
    }
}
