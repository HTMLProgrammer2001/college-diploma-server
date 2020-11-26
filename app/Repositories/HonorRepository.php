<?php


namespace App\Repositories;


use App\Models\Honor;
use App\Repositories\Interfaces\HonorRepositoryInterface;
use App\Repositories\Rules\DateLessRule;
use App\Repositories\Rules\DateMoreRule;
use App\Repositories\Rules\EqualRule;
use App\Repositories\Rules\LikeRule;
use App\Repositories\Rules\SortRule;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class HonorRepository extends BaseRepository implements HonorRepositoryInterface
{
    private $model = Honor::class;
    protected $sortFields = [
        'ID' => 'id',
        'title' => 'title',
        'datePresentation' => 'date_presentation'
    ];

    public function createRules(array $inputData): array
    {
        $rules = [];

        if($inputData['user_id'] ?? null)
            $rules[] = new EqualRule('user_id', $inputData['user_id']);

        if($inputData['filterUser'] ?? null)
            $rules[] = new EqualRule('user_id', $inputData['filterUser']);

        if($inputData['filterTitle'] ?? null)
            $rules[] = new LikeRule('title', $inputData['filterTitle']);

        if($inputData['filterFrom'] ?? null)
            $rules[] = new DateMoreRule('date_presentation', $inputData['filterFrom']);

        if($inputData['filterTo'] ?? null)
            $rules[] = new DateLessRule('date_presentation', $inputData['filterTo']);

        $rules = array_merge($rules, $this->createSortRules($inputData['sort'] ?? null, $this->sortFields));
        return $rules;
    }

    public function getModel(): Model
    {
        return app($this->model);
    }

    public function all(): Collection
    {
        return $this->getModel()->all();
    }

    public function paginateForUser($user_id, ?int $size = null): LengthAwarePaginator
    {
        $size = $size ?? config('app.PAGINATE_SIZE', 10);
        return $this->getModel()->query()->where('user_id', $user_id)->paginate($size);
    }

    public function getUserString(int $user_id): string
    {
        //get all honors
        $honors = $this->getModel()->query()->where('user_id', $user_id)->get();

        //parse string
        $honorsString = $honors->reduce(function(string $acc, $item){
            return $acc . implode(', ', [$item->title, $item->date_presentation, $item->order]) . ';';
        }, '');

        //return info
        return $honorsString ? $honorsString : 'Немає інформації';
    }
}
