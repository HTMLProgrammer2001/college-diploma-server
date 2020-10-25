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
        $sortFields = [
            'ID' => 'id',
            'title' => 'title',
            'date' => 'date_of_publication'
        ];

        $rules = [];
        $rules[] = new HasAssociateRule('authors', new EqualRule('users.id', $request->user()->id));

        if($request->query('filterTitle'))
            $rules[] = new LikeRule('title', $request->query('filterTitle'));

        if($request->query('filterFrom'))
            $rules[] = new DateMoreRule('date_of_publication', $request->query('filterFrom'));

        if($request->query('filterTo'))
            $rules[] = new DateLessRule('date_of_publication', $request->query('filterTo'));

        if(is_array($request->query('sort'))){
            foreach ($request->query('sort') as $sortRuleStr){
                try {
                    $sortRule = json_decode($sortRuleStr);

                    if(!in_array($sortRule->field, array_keys($sortFields)))
                        continue;

                    $rules[] = new SortRule($sortFields[$sortRule->field], $sortRule->direction);
                }
                catch (Exception $exception){}
            }
        }

        $publications = $this->publicationRep->filterPaginate($rules, $request->query('pageSize', 5));
        return new PublicationsGroupResource($publications);
    }
}
