<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\AddDepartmentRequest;
use App\Http\Requests\Department\AllDepartmentsRequest;
use App\Http\Requests\Department\EditDepartmentRequest;
use App\Http\Resources\Departments\DepartmentResource;
use App\Http\Resources\Departments\DepartmentsGroupResource;
use App\Models\Department;
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
        $this->authorizeResource(Department::class);
    }

    /**
     * @param AllDepartmentsRequest $request
     * @return DepartmentsGroupResource
     */
    public function index(AllDepartmentsRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->departmentService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $departments = $this->departmentService->filterPaginate($rules, $pageSize);

        return new DepartmentsGroupResource($departments);
    }

    /**
     * @param Department $department
     * @return DepartmentResource|void
     */
    public function show(Department $department)
    {
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
     * @param Department $department
     * @return DepartmentResource
     */
    public function update(EditDepartmentRequest $request, Department $department)
    {
        $data = $request->all();
        $department = $this->departmentService->update($department->id, $data);

        return new DepartmentResource($department);
    }

    /**
     * @param Department $department
     * @return JsonResponse|void
     */
    public function destroy(Department $department)
    {
        if($this->departmentService->destroy($department->id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }
}
