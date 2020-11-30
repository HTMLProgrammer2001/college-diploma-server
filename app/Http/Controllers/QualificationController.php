<?php

namespace App\Http\Controllers;

use App\Models\Qualification;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;

use App\Services\QualificationService;
use App\Http\Requests\ImportRequest;
use App\Http\Requests\Qualifications\AddQualificationRequest;
use App\Http\Requests\Qualifications\AllQualificationRequest;
use App\Http\Requests\Qualifications\EditQualificationRequest;
use App\Http\Resources\Qualifications\QualificationResource;
use App\Http\Resources\Qualifications\QualificationsGroupResource;
use App\Imports\QualificationsImport;


class QualificationController extends Controller
{
    /**
     * @var QualificationService 
     */
    private $qualificationService;

    /**
     * QualificationController constructor.
     * @param QualificationService $qualificationService
     */
    public function __construct(QualificationService $qualificationService)
    {
        $this->qualificationService = $qualificationService;
        $this->authorizeResource(Qualification::class);
    }

    /**
     * @param AllQualificationRequest $request
     * @return QualificationsGroupResource
     */
    public function index(AllQualificationRequest $request)
    {
        $inputData = $request->query();
        $inputData['user_id'] = $request->query('filterUser');

        $rules = $this->qualificationService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $qualifications = $this->qualificationService->filterPaginate($rules, $pageSize);

        return new QualificationsGroupResource($qualifications);
    }

    /**
     * @param Qualification $qualification
     * @return QualificationResource|void
     */
    public function show(Qualification $qualification)
    {
        if(!$qualification)
            return abort(404);

        return new QualificationResource($qualification);
    }

    /**
     * @param AddQualificationRequest $request
     * @return JsonResponse
     */
    public function store(AddQualificationRequest $request)
    {
        $data = $request->except('name');
        $data['name'] = $this->qualificationService->getQualificationNames()[$request->input('name')];
        $this->qualificationService->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    /**
     * @param EditQualificationRequest $request
     * @param Qualification $qualification
     * @return QualificationResource
     */
    public function update(EditQualificationRequest $request, Qualification $qualification)
    {
        $data = $request->except('name');
        $data['name'] = $this->qualificationService->getQualificationNames()[$request->input('name')];
        $qualification = $this->qualificationService->update($qualification->id, $data);

        return new QualificationResource($qualification);
    }

    /**
     * @param Qualification $qualification
     * @return JsonResponse|void
     */
    public function destroy(Qualification $qualification)
    {
        if($this->qualificationService->destroy($qualification->id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }

    /**
     * @param ImportRequest $request
     * @return JsonResponse
     */
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
