<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportRequest;
use App\Http\Requests\Publication\AddPublicationRequest;
use App\Http\Requests\Publication\AllPublicationRequest;
use App\Http\Requests\Publication\EditPublicationRequest;
use App\Http\Resources\PublicationResource;
use App\Http\Resources\PublicationsGroupResource;
use App\Imports\PublicationsImport;
use App\Repositories\Interfaces\PublicationRepositoryInterface;
use Maatwebsite\Excel\Facades\Excel;

class PublicationController extends Controller
{
    private $publicationRep;

    public function __construct(PublicationRepositoryInterface $publicationRep)
    {
        $this->publicationRep = $publicationRep;
    }

    public function all(AllPublicationRequest $request)
    {
        $inputData = $request->query();
        $inputData['user_id'] = $request->query('filterUser');

        $rules = $this->publicationRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $publications = $this->publicationRep->filterPaginate($rules, $pageSize);

        return new PublicationsGroupResource($publications);
    }

    public function single(int $id)
    {
        $publication = $this->publicationRep->getById($id);

        if(!$publication)
            return abort(404);

        return new PublicationResource($publication);
    }

    public function store(AddPublicationRequest $request)
    {
        $data = $request->except('date');
        $data = array_merge($data, ['date_of_publication' => $request->input('date')]);

        $this->publicationRep->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    public function update(EditPublicationRequest $request, int $id)
    {
        $data = $request->all();
        $publication = $this->publicationRep->update($id, $data);

        return new PublicationResource($publication);
    }

    public function destroy(int $id)
    {
        if($this->publicationRep->destroy($id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }

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
