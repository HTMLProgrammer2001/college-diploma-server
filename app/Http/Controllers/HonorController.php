<?php

namespace App\Http\Controllers;

use App\Http\Requests\Honor\AddHonorRequest;
use App\Http\Requests\Honor\AllHonorRequest;
use App\Http\Requests\Honor\EditHonorRequest;
use App\Http\Requests\ImportRequest;
use App\Http\Resources\HonorResource;
use App\Http\Resources\HonorsGroupResource;
use App\Imports\HonorsImport;
use App\Repositories\Interfaces\HonorRepositoryInterface;
use Maatwebsite\Excel\Facades\Excel;

class HonorController extends Controller
{
    private $honorRep;

    public function __construct(HonorRepositoryInterface $honorRep)
    {
        $this->honorRep = $honorRep;
    }

    public function all(AllHonorRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->honorRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $honors = $this->honorRep->filterPaginate($rules, $pageSize);

        return new HonorsGroupResource($honors);
    }

    public function single(int $id)
    {
        $honor = $this->honorRep->getById($id);

        if(!$honor)
            return abort(404);

        return new HonorResource($honor);
    }

    public function store(AddHonorRequest $request)
    {
        $data = $request->all();
        $this->honorRep->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    public function update(EditHonorRequest $request, int $id)
    {
        $data = $request->all();
        $honor = $this->honorRep->update($id, $data);

        return new HonorResource($honor);
    }

    public function destroy(int $id)
    {
        if($this->honorRep->destroy($id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }

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
