<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\AddDepartmentRequest;
use App\Http\Requests\Department\AllDepartmentsRequest;
use App\Http\Requests\Department\EditDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\DepartmentsGroupResource;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;

class DepartmentController extends Controller
{
    private $departmentRep;

    public function __construct(DepartmentRepositoryInterface $departmentRep)
    {
        $this->departmentRep = $departmentRep;
    }

    public function all(AllDepartmentsRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->departmentRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $departments = $this->departmentRep->filterPaginate($rules, $pageSize);

        return new DepartmentsGroupResource($departments);
    }

    public function single(int $id)
    {
        $department = $this->departmentRep->getById($id);

        if(!$department)
            return abort(404);

        return new DepartmentResource($department);
    }

    public function store(AddDepartmentRequest $request)
    {
        $data = $request->all();
        $this->departmentRep->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    public function update(EditDepartmentRequest $request, int $id)
    {
        $data = $request->all();
        $department = $this->departmentRep->update($id, $data);

        return new DepartmentResource($department);
    }

    public function destroy(int $id)
    {
        if($this->departmentRep->destroy($id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }
}
