<?php


namespace App\Builders;


use App\Models\Department;
use Illuminate\Database\Eloquent\Model;

class DepartmentBuilder implements BuilderInterface
{
    //create model instance
    public function create(array $data): Model
    {
        $department = new Department($data);
        $department->save();

        return $department;
    }

    //update model instance
    public function update(int $id, array $data): Model
    {
        $department = Department::query()->find($id);
        $department->fill($data);
        $department->save();

        return $department;
    }
}
