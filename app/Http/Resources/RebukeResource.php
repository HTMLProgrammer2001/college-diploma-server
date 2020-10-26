<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RebukeResource extends JsonResource
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
            'title' => $this->title,
            'datePresentation' => $this->date_presentation,
            'active' => $this->active,
            'user' => new UserResource($this->user)
        ];
    }
}
