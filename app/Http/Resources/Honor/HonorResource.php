<?php

namespace App\Http\Resources\Honor;

use App\Http\Resources\UserResource;
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
            'type' => $this->type,
            'user' => new UserResource($this->user)
        ];
    }
}
