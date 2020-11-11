<?php

namespace App\Http\Resources\Qualifications;

use Illuminate\Http\Resources\Json\ResourceCollection;

class QualificationsGroupResource extends ResourceCollection
{
    public $collects = QualificationResource::class;

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
