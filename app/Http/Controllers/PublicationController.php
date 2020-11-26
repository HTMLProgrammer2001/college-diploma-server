<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportRequest;
use App\Http\Requests\Publication\AddPublicationRequest;
use App\Http\Requests\Publication\AllPublicationRequest;
use App\Http\Requests\Publication\EditPublicationRequest;
use App\Http\Resources\PublicationResource;
use App\Http\Resources\PublicationsGroupResource;
use App\Imports\PublicationsImport;
use App\Services\PublicationService;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;

class PublicationController extends Controller
{
    /**
     * @var PublicationService
     */
    private $publicationService;

    /**
     * PublicationController constructor.
     * @param PublicationService $publicationService
     */
    public function __construct(PublicationService $publicationService)
    {
        $this->publicationService = $publicationService;
    }

    /**
     * @param AllPublicationRequest $request
     * @return PublicationsGroupResource
     */
    public function all(AllPublicationRequest $request)
    {
        $inputData = $request->query();
        $inputData['user_id'] = $request->query('filterUser');

        $rules = $this->publicationService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $publications = $this->publicationService->filterPaginate($rules, $pageSize);

        return new PublicationsGroupResource($publications);
    }

    /**
     * @param int $id ID of publication to get info
     * @return PublicationResource|void
     */
    public function single(int $id)
    {
        $publication = $this->publicationService->getById($id);

        if(!$publication)
            return abort(404);

        return new PublicationResource($publication);
    }

    /**
     * @param AddPublicationRequest $request
     * @return JsonResponse
     */
    public function store(AddPublicationRequest $request)
    {
        $data = $request->except('date');
        $data = array_merge($data, ['date_of_publication' => $request->input('date')]);

        $this->publicationService->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    /**
     * @param EditPublicationRequest $request
     * @param int $id
     * @return PublicationResource
     */
    public function update(EditPublicationRequest $request, int $id)
    {
        $data = $request->all();
        $publication = $this->publicationService->update($id, $data);

        return new PublicationResource($publication);
    }

    /**
     * @param int $id
     * @return JsonResponse|void
     */
    public function destroy(int $id)
    {
        if($this->publicationService->destroy($id))
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
            Excel::import(new PublicationsImport(), $request->file('importFile'));
        }
        catch(\Exception $exception){
            return response()->json([
                'message' => 'Error in import'
            ], 422);
        }

        return response()->json(['message' => 'Ok']);
    }
}
