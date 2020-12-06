<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfileEducationsRequest;
use App\Http\Requests\Profile\ProfileHonorsRequest;
use App\Http\Requests\Profile\ProfileInternshipRequest;
use App\Http\Requests\Profile\ProfilePublicationRequest;
use App\Http\Requests\Profile\ProfileQualificationRequest;
use App\Http\Requests\Profile\ProfileRebukeRequest;

use App\Http\Resources\Educations\EducationsGroupResource;
use App\Http\Resources\Honor\HonorsGroupResource;
use App\Http\Resources\Internships\InternshipsGroupResource;
use App\Http\Resources\PublicationsGroupResource;
use App\Http\Resources\Qualifications\QualificationsGroupResource;
use App\Http\Resources\Rebukes\RebukesGroupResource;
use App\Services\EducationService;
use App\Services\HonorService;
use App\Services\InternshipService;
use App\Services\PublicationService;
use App\Services\QualificationService;
use App\Services\RebukeService;


class ProfileController extends Controller
{
    /**
     * @var PublicationService 
     */
    private $publicationService;

    /**
     * @var EducationService 
     */
    private $educationService;

    /**
     * @var HonorService 
     */
    private $honorService;

    /**
     * @var RebukeService 
     */
    private $rebukeService;

    /**
     * @var QualificationService 
     */
    private $qualificationService;

    /**
     * @var InternshipService 
     */
    private $internshipService;

    /**
     * ProfileController constructor.
     * @param PublicationService $publicationService
     * @param EducationService $educationService
     * @param HonorService $honorService
     * @param RebukeService $rebukeService
     * @param QualificationService $qualificationService
     * @param InternshipService $internshipService
     */
    public function __construct(PublicationService $publicationService,
        EducationService $educationService, HonorService $honorService,
        RebukeService $rebukeService, QualificationService $qualificationService,
        InternshipService $internshipService)
    {
        $this->publicationService = $publicationService;
        $this->educationService = $educationService;
        $this->honorService = $honorService;
        $this->rebukeService = $rebukeService;
        $this->qualificationService = $qualificationService;
        $this->internshipService = $internshipService;
    }

    /**
     * @param ProfilePublicationRequest $request
     * @param int $id ID of user to get data for
     * @return PublicationsGroupResource
     */
    public function getPublications(ProfilePublicationRequest $request, int $id){
        $inputData = $request->query();
        $inputData['user_id'] = $id;

        $rules = $this->publicationService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $publications = $this->publicationService->filterPaginate($rules, $pageSize);

        return new PublicationsGroupResource($publications);
    }

    /**
     * @param ProfileEducationsRequest $request
     * @param int $id ID of user to get data for
     * @return EducationsGroupResource
     */
    public function getEducations(ProfileEducationsRequest $request, int $id){
        $inputData = $request->query();
        $inputData['user_id'] = $id;

        $rules = $this->educationService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $educations = $this->educationService->filterPaginate($rules, $pageSize);

        return new EducationsGroupResource($educations);
    }

    /**
     * @param ProfileHonorsRequest $request
     * @param int $id ID of user to get data for
     * @return HonorsGroupResource
     */
    public function getHonors(ProfileHonorsRequest $request, int $id){
        $inputData = $request->query();
        $inputData['user_id'] = $id;

        $rules = $this->honorService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $honors = $this->honorService->filterPaginate($rules, $pageSize);

        return new HonorsGroupResource($honors);
    }

    /**
     * @param ProfileRebukeRequest $request
     * @param int $id ID of user to get data for
     * @return RebukesGroupResource
     */
    public function getRebukes(ProfileRebukeRequest $request, int $id){
        $inputData = $request->query();
        $inputData['user_id'] = $id;

        $rules = $this->rebukeService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $rebukes = $this->rebukeService->filterPaginate($rules, $pageSize);

        return new RebukesGroupResource($rebukes);
    }

    /**
     * @param ProfileQualificationRequest $request
     * @param int $id ID of user to get data for
     * @return QualificationsGroupResource
     */
    public function getQualifications(ProfileQualificationRequest $request, int $id){
        $inputData = $request->query();
        $inputData['user_id'] = $id;

        $rules = $this->qualificationService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $qualifications = $this->qualificationService->filterPaginate($rules, $pageSize);
        
        $response = new QualificationsGroupResource($qualifications);
        $response->additional([
           'nextDate' => $this->qualificationService->getNextQualificationDateOf($id)
        ]);
        
        return $response;
    }

    /**
     * @param ProfileInternshipRequest $request
     * @param int $id ID of user to get data for
     * @return InternshipsGroupResource
     */
    public function getInternships(ProfileInternshipRequest $request, int $id){
        $inputData = $request->query();
        $inputData['user_id'] = $id;

        $rules = $this->internshipService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $internships = $this->internshipService->filterPaginate($rules, $pageSize);

        $response = new InternshipsGroupResource($internships);
        $lastInternships = $this->internshipService->getInternshipsFor($request->user()->id);

        $response->additional([
            'hours' => $this->internshipService->getInternshipHoursOf($lastInternships)
        ]);

        return $response;
    }
}
