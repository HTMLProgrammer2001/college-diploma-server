<?php

namespace App\Http\Controllers;


use App\Http\Requests\Education\AddEducationRequest;
use App\Http\Requests\Education\AllEducationRequest;
use App\Http\Requests\Education\EditEducationRequest;
use App\Http\Resources\Educations\EducationResource;
use App\Http\Resources\Educations\EducationsGroupResource;
use App\Repositories\Interfaces\EducationRepositoryInterface;

class EducationController extends Controller
{
    private $educationRep;

    public function __construct(EducationRepositoryInterface $educationRep)
    {
        $this->educationRep = $educationRep;
    }

    public function all(AllEducationRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->educationRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $educations = $this->educationRep->filterPaginate($rules, $pageSize);

        return new EducationsGroupResource($educations);
    }

    public function single(int $id)
    {
        $education = $this->educationRep->getById($id);

        if(!$education)
            return abort(404);

        return new EducationResource($education);
    }

    public function store(AddEducationRequest $request)
    {
        $data = $request->all();
        $data['graduate_year'] = $request->input('graduateYear');
        $this->educationRep->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    public function update(EditEducationRequest $request, int $id)
    {
        $data = $request->all();
        $data['graduate_year'] = $request->input('graduateYear');
        $education = $this->educationRep->update($id, $data);

        return new EducationResource($education);
    }

    public function destroy(int $id)
    {
        if($this->educationRep->destroy($id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }
}
