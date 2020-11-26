<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Commissions\CommissionResource;
use App\Http\Resources\Departments\DepartmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'fullName' => $this->fullName,
            'role' => $this->role,
            'avatar' => $this->getAvatar(),
            'birthday' => $this->birthday,
            'email' => $this->email,
            'address' => $this->address,
            'pedagogicalTitle' => $this->pedagogical_title,
            'academicStatus' => $this->academic_status,
            'academicStatusYear' => $this->academic_status_year,
            'scientificDegree' => $this->scientific_degree,
            'scientificDegreeYear' => $this->scientific_degree_year,
            'experience' => $this->expirience,
            'rank' => $this->rank,
            'commission' => new CommissionResource($this->commission),
            'department' => new DepartmentResource($this->department)
        ];
    }
}
