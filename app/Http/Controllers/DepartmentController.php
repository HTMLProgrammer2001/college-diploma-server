<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\AddDepartmentRequest;
use App\Http\Requests\Department\AllDepartmentsRequest;
use App\Http\Requests\Department\EditDepartmentRequest;
use App\Http\Resources\Departments\DepartmentResource;
use App\Http\Resources\Departments\DepartmentsGroupResource;
use App\Services\DepartmentService;
use Illuminate\Http\JsonResponse;

class DepartmentController extends Controller
{
    /**
     * @var DepartmentService
     */
    private $departmentService;

    /**
     * DepartmentController constructor.
     * @param DepartmentService $departmentService
     */
    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    /**
     * @param AllDepartmentsRequest $request
     * @return DepartmentsGroupResource
     */
    public function all(AllDepartmentsRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->departmentService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $departments = $this->departmentService->filterPaginate($rules, $pageSize);

        return new DepartmentsGroupResource($departments);
    }

    /**
     * @param int $id ID of department to get data
     * @return DepartmentResource|void
     */
    public function single(int $id)
    {
        $department = $this->departmentService->getById($id);

        if(!$department)
            return abort(404);

        return new DepartmentResource($department);
    }

    /**
     * @param AddDepartmentRequest $request
     * @return JsonResponse
     */
    public function store(AddDepartmentRequest $request)
    {
        $data = $request->all();
        $this->departmentService->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    /**
     * @param EditDepartmentRequest $request
     * @param int $id ID of department to update
     * @return DepartmentResource
     */
    public function update(EditDepartmentRequest $request, int $id)
    {
        $data = $request->all();
        $department = $this->departmentService->update($id, $data);

        return new DepartmentResource($department);
    }

    /**
     * @param int $id ID of department to delete
     * @return JsonResponse|void
     */
    public function destroy(int $id)
    {
        if($this->departmentService->destroy($id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }
}
