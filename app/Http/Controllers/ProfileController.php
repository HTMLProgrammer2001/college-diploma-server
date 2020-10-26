<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfileEducationsRequest;
use App\Http\Requests\Profile\ProfileHonorsRequest;
use App\Http\Requests\Profile\ProfilePublicationRequest;
use App\Http\Requests\Profile\ProfileQualificationRequest;
use App\Http\Requests\Profile\ProfileRebukeRequest;

use App\Http\Resources\EducationsGroupResource;
use App\Http\Resources\HonorsGroupResource;
use App\Http\Resources\PublicationsGroupResource;
use App\Http\Resources\QualificationsGroupResource;
use App\Http\Resources\RebukesGroupResource;

use App\Repositories\Interfaces\EducationRepositoryInterface;
use App\Repositories\Interfaces\HonorRepositoryInterface;
use App\Repositories\Interfaces\PublicationRepositoryInterface;
use App\Repositories\Interfaces\QualificationRepositoryInterface;
use App\Repositories\Interfaces\RebukeRepositoryInterface;

class ProfileController extends Controller
{
    private $publicationRep;
    private $educationRep;
    private $honorRep;
    private $rebukeRep;
    private $qualificationRep;

    public function __construct(PublicationRepositoryInterface $publicationRep,
        EducationRepositoryInterface $educationRep, HonorRepositoryInterface $honorRep,
        RebukeRepositoryInterface $rebukeRep, QualificationRepositoryInterface $qualificationRep)
    {
        $this->publicationRep = $publicationRep;
        $this->educationRep = $educationRep;
        $this->honorRep = $honorRep;
        $this->rebukeRep = $rebukeRep;
        $this->qualificationRep = $qualificationRep;
    }

    public function getPublications(ProfilePublicationRequest $request){
        $inputData = $request->query();
        $inputData['user_id'] = $request->user()->id;

        $rules = $this->publicationRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $publications = $this->publicationRep->filterPaginate($rules, $pageSize);

        return new PublicationsGroupResource($publications);
    }

    public function getEducations(ProfileEducationsRequest $request){
        $inputData = $request->query();
        $inputData['user_id'] = $request->user()->id;

        $rules = $this->educationRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $educations = $this->educationRep->filterPaginate($rules, $pageSize);

        return new EducationsGroupResource($educations);
    }

    public function getHonors(ProfileHonorsRequest $request){
        $inputData = $request->query();
        $inputData['user_id'] = $request->user()->id;

        $rules = $this->honorRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $honors = $this->honorRep->filterPaginate($rules, $pageSize);

        return new HonorsGroupResource($honors);
    }

    public function getRebukes(ProfileRebukeRequest $request){
        $inputData = $request->query();
        $inputData['user_id'] = $request->user()->id;

        $rules = $this->rebukeRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $rebukes = $this->rebukeRep->filterPaginate($rules, $pageSize);

        return new RebukesGroupResource($rebukes);
    }

    public function getQualifications(ProfileQualificationRequest $request){
        $inputData = $request->query();
        $inputData['user_id'] = $request->user()->id;

        $rules = $this->qualificationRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $qualifications = $this->qualificationRep->filterPaginate($rules, $pageSize);

        return new QualificationsGroupResource($qualifications);
    }
}
