<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests\ImportRequest;
use App\Http\Requests\Qualifications\AddQualificationRequest;
use App\Http\Requests\Qualifications\AllQualificationRequest;
use App\Http\Requests\Qualifications\EditQualificationRequest;
use App\Http\Resources\Qualifications\QualificationResource;
use App\Http\Resources\Qualifications\QualificationsGroupResource;
use App\Imports\QualificationsImport;
use App\Repositories\Interfaces\QualificationRepositoryInterface;


class QualificationController extends Controller
{
    private $qualificationRep;

    public function __construct(QualificationRepositoryInterface $qualificationRep)
    {
        $this->qualificationRep = $qualificationRep;
    }

    public function all(AllQualificationRequest $request)
    {
        $inputData = $request->query();
        $inputData['user_id'] = $request->query('filterUser');

        $rules = $this->qualificationRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $qualifications = $this->qualificationRep->filterPaginate($rules, $pageSize);

        return new QualificationsGroupResource($qualifications);
    }

    public function single(int $id)
    {
        $qualification = $this->qualificationRep->getById($id);

        if(!$qualification)
            return abort(404);

        return new QualificationResource($qualification);
    }

    public function store(AddQualificationRequest $request)
    {
        $data = $request->except('name');
        $data['name'] = $this->qualificationRep->getQualificationNames()[$request->input('name')];
        $this->qualificationRep->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    public function update(EditQualificationRequest $request, int $id)
    {
        $data = $request->except('name');
        $data['name'] = $this->qualificationRep->getQualificationNames()[$request->input('name')];
        $qualification = $this->qualificationRep->update($id, $data);

        return new QualificationResource($qualification);
    }

    public function destroy(int $id)
    {
        if($this->qualificationRep->destroy($id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }

    public function import(ImportRequest $request)
    {
        try {
            //Import models
            Excel::import(new QualificationsImport(), $request->file('importFile'));
        }
        catch(\Exception $exception){
            return response()->json([
                'message' => 'Error in import'
            ], 422);
        }

        return response()->json(['message' => 'Ok']);
    }
}
