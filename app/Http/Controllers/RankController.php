<?php

namespace App\Http\Controllers;


use App\Http\Requests\Rank\AddRankRequest;
use App\Http\Requests\Rank\AllRanksRequest;
use App\Http\Requests\Rank\EditRankRequest;
use App\Http\Resources\Ranks\RankResource;
use App\Http\Resources\Ranks\RanksGroupResource;
use App\Models\Rank;
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
        $this->authorizeResource(Rank::class);
    }

    /**
     * @param AllRanksRequest $request
     * @return RanksGroupResource
     */
    public function index(AllRanksRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->rankService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $ranks = $this->rankService->filterPaginate($rules, $pageSize);

        return new RanksGroupResource($ranks);
    }

    /**
     * @param Rank $rank
     * @return RankResource|void
     */
    public function show(Rank $rank)
    {
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
     * @param Rank $rank
     * @return RankResource
     */
    public function update(EditRankRequest $request, Rank $rank)
    {
        $data = $request->all();
        $rank = $this->rankService->update($rank->id, $data);

        return new RankResource($rank);
    }

    /**
     * @param Rank $rank
     * @return JsonResponse|void
     */
    public function destroy(Rank $rank)
    {
        if($this->rankService->destroy($rank->id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }
}
