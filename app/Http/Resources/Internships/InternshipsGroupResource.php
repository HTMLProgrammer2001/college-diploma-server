<?php

namespace App\Http\Resources\Internships;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InternshipsGroupResource extends ResourceCollection
{
    public $collects = InternshipResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
