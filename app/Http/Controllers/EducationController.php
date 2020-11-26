<?php

namespace App\Http\Controllers;


use App\Http\Requests\Education\AddEducationRequest;
use App\Http\Requests\Education\AllEducationRequest;
use App\Http\Requests\Education\EditEducationRequest;
use App\Http\Resources\Educations\EducationResource;
use App\Http\Resources\Educations\EducationsGroupResource;
use App\Services\EducationService;
use Illuminate\Http\JsonResponse;

class EducationController extends Controller
{
    /**
     * @var EducationService
     */
    private $educationService;

    /**
     * EducationController constructor.
     * @param EducationService $educationService
     */
    public function __construct(EducationService $educationService)
    {
        $this->educationService = $educationService;
    }

    /**
     * @param AllEducationRequest $request
     * @return EducationsGroupResource
     */
    public function all(AllEducationRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->educationService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $educations = $this->educationService->filterPaginate($rules, $pageSize);

        return new EducationsGroupResource($educations);
    }

    /**
     * @param int $id ID of education to get
     * @return EducationResource|void
     */
    public function single(int $id)
    {
        $education = $this->educationService->getById($id);

        if(!$education)
            return abort(404);

        return new EducationResource($education);
    }

    /**
     * @param AddEducationRequest $request
     * @return JsonResponse
     */
    public function store(AddEducationRequest $request)
    {
        $data = $request->all();
        $data['graduate_year'] = $request->input('graduateYear');
        $this->educationService->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    /**
     * @param EditEducationRequest $request
     * @param int $id ID of education to update
     * @return EducationResource
     */
    public function update(EditEducationRequest $request, int $id)
    {
        $data = $request->all();
        $data['graduate_year'] = $request->input('graduateYear');
        $education = $this->educationService->update($id, $data);

        return new EducationResource($education);
    }

    /**
     * @param int $id ID of education to delete
     * @return JsonResponse|void
     */
    public function destroy(int $id)
    {
        if($this->educationService->destroy($id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }
}
