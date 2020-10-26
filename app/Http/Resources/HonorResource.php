<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HonorResource extends JsonResource
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
            'order' => $this->order,
            'datePresentation' => $this->date_presentation,
            'title' => $this->title,
            'active' => $this->active,
            'type' => $this->type,
            'user' => new UserResource($this->user)
        ];
    }
}
