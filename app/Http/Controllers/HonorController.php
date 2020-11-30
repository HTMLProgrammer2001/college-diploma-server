<?php

namespace App\Http\Controllers;

use App\Http\Requests\Honor\AddHonorRequest;
use App\Http\Requests\Honor\AllHonorRequest;
use App\Http\Requests\Honor\EditHonorRequest;
use App\Http\Requests\ImportRequest;
use App\Http\Resources\Honor\HonorResource;
use App\Http\Resources\Honor\HonorsGroupResource;
use App\Imports\HonorsImport;
use App\Models\Honor;
use App\Services\HonorService;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;

class HonorController extends Controller
{
    /**
     * @var HonorService
     */
    private $honorService;

    /**
     * HonorController constructor.
     * @param HonorService $honorService
     */
    public function __construct(HonorService $honorService)
    {
        $this->honorService = $honorService;
        $this->authorizeResource(Honor::class);
    }

    /**
     * @param AllHonorRequest $request
     * @return HonorsGroupResource
     */
    public function index(AllHonorRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->honorService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $honors = $this->honorService->filterPaginate($rules, $pageSize);

        return new HonorsGroupResource($honors);
    }

    /**
     * @param Honor $honor
     * @return HonorResource|void
     */
    public function show(Honor $honor)
    {
        if(!$honor)
            return abort(404);

        return new HonorResource($honor);
    }

    /**
     * @param AddHonorRequest $request
     * @return JsonResponse
     */
    public function store(AddHonorRequest $request)
    {
        $data = $request->except('datePresentation');
        $data['date_presentation'] = $request->input('datePresentation');
        $this->honorService->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    /**
     * @param EditHonorRequest $request
     * @param Honor $honor
     * @return HonorResource
     */
    public function update(EditHonorRequest $request, Honor $honor)
    {
        $data = $request->all();
        $honor = $this->honorService->update($honor->id, $data);

        return new HonorResource($honor);
    }

    /**
     * @param Honor $honor
     * @return JsonResponse|void
     */
    public function destroy(Honor $honor)
    {
        if($this->honorService->destroy($honor->id))
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
            Excel::import(new HonorsImport(), $request->file('importFile'));
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
