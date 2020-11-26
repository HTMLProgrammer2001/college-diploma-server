<?php

namespace App\Http\Controllers;


use App\Http\Requests\ImportRequest;
use App\Http\Requests\Rebuke\AddRebukeRequest;
use App\Http\Requests\Rebuke\AllRebukeRequest;
use App\Http\Requests\Rebuke\EditRebukeRequest;
use App\Http\Resources\Rebukes\RebukeResource;
use App\Http\Resources\Rebukes\RebukesGroupResource;
use App\Imports\RebukesImport;
use App\Services\RebukeService;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;

class RebukeController extends Controller
{
    /**
     * @var RebukeService
     */
    private $rebukeRep;

    /**
     * RebukeController constructor.
     * @param RebukeService $rebukeRep
     */
    public function __construct(RebukeService $rebukeRep)
    {
        $this->rebukeRep = $rebukeRep;
    }

    /**
     * @param AllRebukeRequest $request
     * @return RebukesGroupResource
     */
    public function all(AllRebukeRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->rebukeRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $rebukes = $this->rebukeRep->filterPaginate($rules, $pageSize);

        return new RebukesGroupResource($rebukes);
    }

    /**
     * @param int $id
     * @return RebukeResource|void
     */
    public function single(int $id)
    {
        $rebuke = $this->rebukeRep->getById($id);

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
        $this->rebukeRep->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    /**
     * @param EditRebukeRequest $request
     * @param int $id
     * @return RebukeResource
     */
    public function update(EditRebukeRequest $request, int $id)
    {
        $data = $request->all();
        $rebuke = $this->rebukeRep->update($id, $data);

        return new RebukeResource($rebuke);
    }

    /**
     * @param int $id
     * @return JsonResponse|void
     */
    public function destroy(int $id)
    {
        if($this->rebukeRep->destroy($id))
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
