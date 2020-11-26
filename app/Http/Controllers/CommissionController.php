<?php

namespace App\Http\Controllers;

use App\Http\Requests\Commission\AddCommissionRequest;
use App\Http\Requests\Commission\AllCommissionsRequest;
use App\Http\Requests\Commission\EditCommissionRequest;
use App\Http\Resources\Commissions\CommissionResource;
use App\Http\Resources\Commissions\CommissionsGroupResource;
use App\Services\CommissionService;
use Illuminate\Http\JsonResponse;

class CommissionController extends Controller
{
    /**
     * @var CommissionService
     */
    private $commissionService;

    /**
     * CommissionController constructor.
     * @param CommissionService $commissionService
     */
    public function __construct(CommissionService $commissionService)
    {
        $this->commissionService = $commissionService;
    }

    /**
     * @param AllCommissionsRequest $request
     * @return CommissionsGroupResource
     */
    public function all(AllCommissionsRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->commissionService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $departments = $this->commissionService->filterPaginate($rules, $pageSize);

        return new CommissionsGroupResource($departments);
    }

    /**
     * @param int $id
     * @return CommissionResource|void
     */
    public function single(int $id)
    {
        $commission = $this->commissionService->getById($id);

        if(!$commission)
            return abort(404);

        return new CommissionResource($commission);
    }

    /**
     * @param AddCommissionRequest $request
     * @return JsonResponse
     */
    public function store(AddCommissionRequest $request)
    {
        $data = $request->all();
        $this->commissionService->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    /**
     * @param EditCommissionRequest $request
     * @param int $id ID of commission to update
     * @return CommissionResource
     */
    public function update(EditCommissionRequest $request, int $id)
    {
        $data = $request->all();
        $commission = $this->commissionService->update($id, $data);

        return new CommissionResource($commission);
    }

    /**
     * @param int $id ID of commission to delete
     * @return JsonResponse|void
     */
    public function destroy(int $id)
    {
        if($this->commissionService->destroy($id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }
}
