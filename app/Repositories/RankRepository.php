<?php


namespace App\Repositories;


use App\Models\Rank;
use App\Repositories\Interfaces\RankRepositoryInterface;
use App\Repositories\Rules\LikeRule;
use Illuminate\Database\Eloquent\Model;

class RankRepository extends BaseRepository implements RankRepositoryInterface
{
    private $model = Rank::class;
    private $sortFields = [
        'ID' => 'id',
        'name' => 'name'
    ];

    public function createRules(array $inputData): array
    {
        $rules = [];

        if($inputData['filterName'] ?? null)
            $rules[] = new LikeRule('name', $inputData['filterName']);

        $rules = array_merge($rules, $this->createSortRules($inputData['sort'] ?? null, $this->sortFields));
        return $rules;
    }

    public function getModel(): Model
    {
        return app($this->model);
    }

    public function create($data)
    {
        $rank = $this->getModel()->query()->newModelInstance($data);
        $rank->save();

        return $rank;
    }

    public function update($id, $data)
    {
        $rank = $this->getModel()->query()->findOrFail($id);
        $rank->fill($data);
        $rank->save();

        return $rank;
    }

    public function all()
    {
        return $this->getModel()->all();
    }

    public function getForCombo()
    {
        return $this->getModel()->all('id', 'name');
    }

    public function getForExportList()
    {
        //return to_export_list($this->getModel()->all('id', 'name')->toArray());
        return [];
    }
}
