<?php


namespace App\Repositories;


use App\Models\Commission;
use App\Repositories\Interfaces\CommissionRepositoryInterface;
use App\Repositories\Rules\LikeRule;
use Illuminate\Database\Eloquent\Model;

class CommissionRepository extends BaseRepository implements CommissionRepositoryInterface
{
    private $model = Commission::class;
    private $sortFields = [
        'ID' => 'id',
        'name' => 'name'
    ];

    public function createRules(array $inputData): array
    {
        $rules = [];

        if($inputData['filterName'] ?? null)
            $rules[] = new LikeRule('name', $inputData['filterName']);

        return array_merge($rules, $this->createSortRules($inputData['sort'] ?? null, $this->sortFields));
    }

    public function getModel(): Model
    {
        return app($this->model);
    }

    public function all(){
        return $this->getModel()->all();
    }

    public function getForCombo(){
        return $this->getModel()->all('id', 'name');
    }

    public function getForExportList()
    {
        return to_export_list($this->getModel()->all('id', 'name')->toArray());
    }
}
