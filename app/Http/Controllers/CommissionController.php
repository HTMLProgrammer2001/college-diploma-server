<?php

namespace App\Http\Controllers;

use App\Http\Requests\Commission\AddCommissionRequest;
use App\Http\Requests\Commission\AllCommissionsRequest;
use App\Http\Requests\Commission\EditCommissionRequest;
use App\Http\Resources\Commissions\CommissionResource;
use App\Http\Resources\Commissions\CommissionsGroupResource;
use App\Repositories\Interfaces\CommissionRepositoryInterface;

class CommissionController extends Controller
{
    private $commissionRep;

    public function __construct(CommissionRepositoryInterface $departmentRep)
    {
        $this->commissionRep = $departmentRep;
    }

    public function all(AllCommissionsRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->commissionRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $departments = $this->commissionRep->filterPaginate($rules, $pageSize);

        return new CommissionsGroupResource($departments);
    }

    public function single(int $id)
    {
        $commission = $this->commissionRep->getById($id);

        if(!$commission)
            return abort(404);

        return new CommissionResource($commission);
    }

    public function store(AddCommissionRequest $request)
    {
        $data = $request->all();
        $this->commissionRep->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    public function update(EditCommissionRequest $request, int $id)
    {
        $data = $request->all();
        $commission = $this->commissionRep->update($id, $data);

        return new CommissionResource($commission);
    }

    public function destroy(int $id)
    {
        if($this->commissionRep->destroy($id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }
}
