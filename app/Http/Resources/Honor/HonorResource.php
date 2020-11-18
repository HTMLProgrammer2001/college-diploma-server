<?php

namespace App\Http\Resources\Honor;

use App\Http\Resources\Users\UserResource;
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
            'title' => $this->title,
            'order' => $this->order,
            'datePresentation' => $this->date_presentation,
            'user' => new UserResource($this->user),
            'active' => $this->active
        ];
    }
}
