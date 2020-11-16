<?php

namespace App\Http\Resources\Departments;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SearchDepartmentsGroupResource extends ResourceCollection
{
    public $collects = SearchDepartmentResource::class;

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
