<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfilePublicationRequest;
use App\Http\Resources\PublicationsGroupResource;
use App\Repositories\Interfaces\PublicationRepositoryInterface;

use App\Repositories\Rules\DateLessRule;
use App\Repositories\Rules\DateMoreRule;
use App\Repositories\Rules\EqualRule;
use App\Repositories\Rules\HasAssociateRule;
use App\Repositories\Rules\LikeRule;
use App\Repositories\Rules\SortRule;

class ProfileController extends Controller
{
    private $publicationRep;

    public function __construct(PublicationRepositoryInterface $publicationRep)
    {
        $this->publicationRep = $publicationRep;
    }

    public function getPublications(ProfilePublicationRequest $request){
        $rules = [];
        $rules[] = new HasAssociateRule('authors', new EqualRule('users.id', $request->user()->id));

        if($request->query('filterTitle'))
            $rules[] = new LikeRule('title', $request->query('filterTitle'));

        if($request->query('filterFrom'))
            $rules[] = new DateMoreRule('date_of_publication', $request->query('filterFrom'));

        if($request->query('filterTo'))
            $rules[] = new DateLessRule('date_of_publication', $request->query('filterTo'));

        if($request->query('sortId'))
            $rules[] = new SortRule('id', $request->query('sortId'));

        if($request->query('sortTitle'))
            $rules[] = new SortRule('title', $request->query('sortTitle'));

        if($request->query('sortDate'))
            $rules[] = new SortRule('date_of_publication', $request->query('sortDate'));

        $publications = $this->publicationRep->filterPaginate($rules, $request->query('pageSize', 5));

        return new PublicationsGroupResource($publications);
    }
}
