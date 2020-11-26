<?php

namespace App\Http\Controllers;


use App\Http\Requests\Rank\AddRankRequest;
use App\Http\Requests\Rank\AllRanksRequest;
use App\Http\Requests\Rank\EditRankRequest;
use App\Http\Resources\Ranks\RankResource;
use App\Http\Resources\Ranks\RanksGroupResource;
use App\Services\RankService;
use Illuminate\Http\JsonResponse;

class RankController extends Controller
{
    /**
     * @var RankService
     */
    private $rankService;

    /**
     * RankController constructor.
     * @param RankService $rankService
     */
    public function __construct(RankService $rankService)
    {
        $this->rankService = $rankService;
    }

    /**
     * @param AllRanksRequest $request
     * @return RanksGroupResource
     */
    public function all(AllRanksRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->rankService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $ranks = $this->rankService->filterPaginate($rules, $pageSize);

        return new RanksGroupResource($ranks);
    }

    /**
     * @param int $id
     * @return RankResource|void
     */
    public function single(int $id)
    {
        $rank = $this->rankService->getById($id);

        if(!$rank)
            return abort(404);

        return new RankResource($rank);
    }

    /**
     * @param AddRankRequest $request
     * @return JsonResponse
     */
    public function store(AddRankRequest $request)
    {
        $data = $request->all();
        $this->rankService->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    /**
     * @param EditRankRequest $request
     * @param int $id
     * @return RankResource
     */
    public function update(EditRankRequest $request, int $id)
    {
        $data = $request->all();
        $rank = $this->rankService->update($id, $data);

        return new RankResource($rank);
    }

    /**
     * @param int $id
     * @return JsonResponse|void
     */
    public function destroy(int $id)
    {
        if($this->rankService->destroy($id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }
}
