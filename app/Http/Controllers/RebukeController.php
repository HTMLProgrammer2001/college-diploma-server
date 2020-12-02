<?php

namespace App\Http\Controllers;


use App\Http\Requests\ImportRequest;
use App\Http\Requests\Rebuke\AddRebukeRequest;
use App\Http\Requests\Rebuke\AllRebukeRequest;
use App\Http\Requests\Rebuke\EditRebukeRequest;
use App\Http\Resources\Rebukes\RebukeResource;
use App\Http\Resources\Rebukes\RebukesGroupResource;
use App\Imports\RebukesImport;
use App\Models\Rebuke;
use App\Services\RebukeService;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;

class RebukeController extends Controller
{
    /**
     * @var RebukeService
     */
    private $rebukeService;

    /**
     * RebukeController constructor.
     * @param RebukeService $rebukeService
     */
    public function __construct(RebukeService $rebukeService)
    {
        $this->rebukeService = $rebukeService;
        $this->authorizeResource(Rebuke::class);
    }

    /**
     * @param AllRebukeRequest $request
     * @return RebukesGroupResource
     */
    public function index(AllRebukeRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->rebukeService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $rebukes = $this->rebukeService->filterPaginate($rules, $pageSize);

        return new RebukesGroupResource($rebukes);
    }

    /**
     * @param Rebuke $rebuke
     * @return RebukeResource|void
     */
    public function show(Rebuke $rebuke)
    {
        if(!$rebuke)
            return abort(404);

        return new RebukeResource($rebuke);
    }

    /**
     * @param AddRebukeRequest $request
     * @return JsonResponse
     */
    public function store(AddRebukeRequest $request)
    {
        $data = $request->except('datePresentation');
        $data['date_presentation'] = $request->input('datePresentation');
        $this->rebukeService->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    /**
     * @param EditRebukeRequest $request
     * @param Rebuke $rebuke
     * @return RebukeResource
     */
    public function update(EditRebukeRequest $request, Rebuke $rebuke)
    {
        $data = $request->all();
        $rebuke = $this->rebukeService->update($rebuke->id, $data);

        return new RebukeResource($rebuke);
    }

    /**
     * @param Rebuke $rebuke
     * @return JsonResponse|void
     */
    public function destroy(Rebuke $rebuke)
    {
        if($this->rebukeService->destroy($rebuke->id))
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
            Excel::import(new RebukesImport(), $request->file('importFile'));
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
