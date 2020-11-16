<?php

namespace App\Http\Controllers;


use App\Http\Requests\Rank\AddRankRequest;
use App\Http\Requests\Rank\AllRanksRequest;
use App\Http\Requests\Rank\EditRankRequest;
use App\Http\Resources\Ranks\RankResource;
use App\Http\Resources\Ranks\RanksGroupResource;
use App\Repositories\Interfaces\RankRepositoryInterface;

class RankController extends Controller
{
    private $rankRep;

    public function __construct(RankRepositoryInterface $rankRep)
    {
        $this->rankRep = $rankRep;
    }

    public function all(AllRanksRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->rankRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $ranks = $this->rankRep->filterPaginate($rules, $pageSize);

        return new RanksGroupResource($ranks);
    }

    public function single(int $id)
    {
        $rank = $this->rankRep->getById($id);

        if(!$rank)
            return abort(404);

        return new RankResource($rank);
    }

    public function store(AddRankRequest $request)
    {
        $data = $request->all();
        $this->rankRep->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    public function update(EditRankRequest $request, int $id)
    {
        $data = $request->all();
        $rank = $this->rankRep->update($id, $data);

        return new RankResource($rank);
    }

    public function destroy(int $id)
    {
        if($this->rankRep->destroy($id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }
}
