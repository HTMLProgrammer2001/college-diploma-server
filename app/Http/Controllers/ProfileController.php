<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfileEducationsRequest;
use App\Http\Requests\Profile\ProfilePublicationRequest;

use App\Http\Resources\EducationsGroupResource;
use App\Http\Resources\PublicationsGroupResource;

use App\Repositories\Interfaces\EducationRepositoryInterface;
use App\Repositories\Interfaces\PublicationRepositoryInterface;

class ProfileController extends Controller
{
    private $publicationRep;
    private $educationRep;

    public function __construct(PublicationRepositoryInterface $publicationRep,
        EducationRepositoryInterface $educationRep)
    {
        $this->publicationRep = $publicationRep;
        $this->educationRep = $educationRep;
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
}
