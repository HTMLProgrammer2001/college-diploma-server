<?php

namespace App\Http\Controllers;


use App\Http\Requests\Education\AddEducationRequest;
use App\Http\Requests\Education\AllEducationRequest;
use App\Http\Requests\Education\EditEducationRequest;
use App\Http\Resources\Educations\EducationResource;
use App\Http\Resources\Educations\EducationsGroupResource;
use App\Models\Education;
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
        $this->authorizeResource(Education::class);
    }

    /**
     * @param AllEducationRequest $request
     * @return EducationsGroupResource
     */
    public function index(AllEducationRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->educationService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $educations = $this->educationService->filterPaginate($rules, $pageSize);

        return new EducationsGroupResource($educations);
    }

    /**
     * @param Education $education
     * @return EducationResource|void
     */
    public function single(Education $education)
    {
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
     * @param Education $education
     * @return EducationResource
     */
    public function update(EditEducationRequest $request, Education $education)
    {
        $data = $request->all();
        $data['graduate_year'] = $request->input('graduateYear');
        $education = $this->educationService->update($education->id, $data);

        return new EducationResource($education);
    }

    /**
     * @param Education $education
     * @return JsonResponse|void
     */
    public function destroy(Education $education)
    {
        if($this->educationService->destroy($education->id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }
}
