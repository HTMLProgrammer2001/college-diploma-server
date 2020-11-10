<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests\ImportRequest;
use App\Http\Requests\Internship\AddInternshipRequest;
use App\Http\Requests\Internship\AllInternshipsRequest;
use App\Http\Requests\Internship\EditInternshipRequest;
use App\Http\Resources\Internships\InternshipResource;
use App\Http\Resources\Internships\InternshipsGroupResource;
use App\Imports\InternshipsImport;
use App\Repositories\Interfaces\InternshipRepositoryInterface;

class InternshipController extends Controller
{
    private $internshipRep;

    public function __construct(InternshipRepositoryInterface $internshipRep)
    {
        $this->internshipRep = $internshipRep;
    }

    public function all(AllInternshipsRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->internshipRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $internships = $this->internshipRep->filterPaginate($rules, $pageSize);

        return new InternshipsGroupResource($internships);
    }

    public function single(int $id)
    {
        $internship = $this->internshipRep->getById($id);

        if(!$internship)
            return abort(404);

        return new InternshipResource($internship);
    }

    public function store(AddInternshipRequest $request)
    {
        $data = $request->all();
        $this->internshipRep->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    public function update(EditInternshipRequest $request, int $id)
    {
        $data = $request->all();
        $internship = $this->internshipRep->update($id, $data);

        return new InternshipResource($internship);
    }

    public function destroy(int $id)
    {
        if($this->internshipRep->destroy($id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }

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
