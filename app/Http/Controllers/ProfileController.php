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
use App\Repositories\Interfaces\EducationRepositoryInterface;
use App\Repositories\Interfaces\HonorRepositoryInterface;
use App\Repositories\Interfaces\InternshipRepositoryInterface;
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
    private $internshipRep;

    public function __construct(PublicationRepositoryInterface $publicationRep,
        EducationRepositoryInterface $educationRep, HonorRepositoryInterface $honorRep,
        RebukeRepositoryInterface $rebukeRep, QualificationRepositoryInterface $qualificationRep,
        InternshipRepositoryInterface $internshipRep)
    {
        $this->publicationRep = $publicationRep;
        $this->educationRep = $educationRep;
        $this->honorRep = $honorRep;
        $this->rebukeRep = $rebukeRep;
        $this->qualificationRep = $qualificationRep;
        $this->internshipRep = $internshipRep;
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
        
        $response = new QualificationsGroupResource($qualifications);
        $response->additional([
           'nextDate' => $this->qualificationRep->getNextQualificationDateOf($request->user()->id)
        ]);
        
        return $response;
    }

    public function getInternships(ProfileInternshipRequest $request){
        $inputData = $request->query();
        $inputData['user_id'] = $request->user()->id;

        $rules = $this->internshipRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $internships = $this->internshipRep->filterPaginate($rules, $pageSize);

        $response = new InternshipsGroupResource($internships);
        $lastInternships = $this->internshipRep->getInternshipsFor($request->user()->id);

        $response->additional([
            'hours' => $this->internshipRep->getInternshipHoursOf($lastInternships)
        ]);

        return $response;
    }
}
