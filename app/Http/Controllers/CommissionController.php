<?php

namespace App\Http\Controllers;

use App\Http\Requests\Commission\AddCommissionRequest;
use App\Http\Requests\Commission\AllCommissionsRequest;
use App\Http\Requests\Commission\EditCommissionRequest;
use App\Http\Resources\Commissions\CommissionResource;
use App\Http\Resources\Commissions\CommissionsGroupResource;
use App\Models\Commission;
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
        $this->authorizeResource(Commission::class);
    }

    /**
     * @param AllCommissionsRequest $request
     * @return CommissionsGroupResource
     */
    public function index(AllCommissionsRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->commissionService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $departments = $this->commissionService->filterPaginate($rules, $pageSize);

        return new CommissionsGroupResource($departments);
    }

    /**
     * @param Commission $commission
     * @return CommissionResource|void
     */
    public function show(Commission $commission)
    {
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
     * @param Commission $commission
     * @return CommissionResource
     */
    public function update(EditCommissionRequest $request, Commission $commission)
    {
        $data = $request->all();
        $commission = $this->commissionService->update($commission->id, $data);

        return new CommissionResource($commission);
    }

    /**
     * @param Commission $commission
     * @return JsonResponse|void
     */
    public function destroy(Commission $commission)
    {
        if($this->commissionService->destroy($commission->id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }
}
