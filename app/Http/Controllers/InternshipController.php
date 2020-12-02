<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Services\InternshipService;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests\ImportRequest;
use App\Http\Requests\Internship\AddInternshipRequest;
use App\Http\Requests\Internship\AllInternshipsRequest;
use App\Http\Requests\Internship\EditInternshipRequest;
use App\Http\Resources\Internships\InternshipResource;
use App\Http\Resources\Internships\InternshipsGroupResource;
use App\Imports\InternshipsImport;

class InternshipController extends Controller
{
    /**
     * @var InternshipService
     */
    private $internshipService;

    /**
     * InternshipController constructor.
     * @param InternshipService $internshipService
     */
    public function __construct(InternshipService $internshipService)
    {
        $this->internshipService = $internshipService;
        $this->authorizeResource(Internship::class);
    }

    /**
     * @param AllInternshipsRequest $request
     * @return InternshipsGroupResource
     */
    public function index(AllInternshipsRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->internshipService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $internships = $this->internshipService->filterPaginate($rules, $pageSize);

        return new InternshipsGroupResource($internships);
    }

    /**
     * @param Internship $internship
     * @return InternshipResource|void
     */
    public function show(Internship $internship)
    {
        if(!$internship)
            return abort(404);

        return new InternshipResource($internship);
    }

    /**
     * @param AddInternshipRequest $request
     * @return JsonResponse
     */
    public function store(AddInternshipRequest $request)
    {
        $data = $request->all();
        $this->internshipService->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    /**
     * @param EditInternshipRequest $request
     * @param Internship $internship
     * @return InternshipResource
     */
    public function update(EditInternshipRequest $request, Internship $internship)
    {
        $data = $request->all();
        $internship = $this->internshipService->update($internship->id, $data);

        return new InternshipResource($internship);
    }

    /**
     * @param Internship $internship
     * @return JsonResponse|void
     */
    public function destroy(Internship $internship)
    {
        if($this->internshipService->destroy($internship->id))
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
            Excel::import(new InternshipsImport(), $request->file('importFile'));
        }
        catch(\Exception $exception){
            return response()->json([
                'message' => 'Error in import'
            ], 422);
        }

        //return success response
        return response()->json(['message' => 'Ok']);
    }
}
