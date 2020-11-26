<?php


namespace App\Repositories;



use App\Models\InternCategory;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Rules\LikeRule;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    private $model = InternCategory::class;
    private $sortFields = [
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

    public function getForCombo()
    {
        return $this->getModel()->all('id', 'name');
    }

    public function getForExportList(): array
    {
        return to_export_list($this->getModel()->all('id', 'name')->toArray());
    }
}
