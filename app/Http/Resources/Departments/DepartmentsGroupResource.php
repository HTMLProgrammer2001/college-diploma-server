<?php

namespace App\Http\Resources\Departments;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DepartmentsGroupResource extends ResourceCollection
{
    public $collects = DepartmentResource::class;

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
