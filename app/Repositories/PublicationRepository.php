<?php


namespace App\Repositories;


use App\Models\Publication;
use App\Repositories\Interfaces\PublicationRepositoryInterface;

use App\Repositories\Rules\DateLessRule;
use App\Repositories\Rules\DateMoreRule;
use App\Repositories\Rules\EqualRule;
use App\Repositories\Rules\HasAssociateRule;
use App\Repositories\Rules\LikeRule;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PublicationRepository extends BaseRepository implements PublicationRepositoryInterface
{
    private $model = Publication::class;
    protected $sortFields = [
        'ID' => 'id',
        'title' => 'title',
        'date' => 'date_of_publication'
    ];

    public function getModel(): Model
    {
        return app($this->model);
    }

    public function createRules(array $inputData): array
    {
        $rules = [];

        if($inputData['user_id'] ?? null)
            $rules[] = new HasAssociateRule('authors',
                new EqualRule('users.id', $inputData['user_id']));

        if($inputData['filterTitle'] ?? null)
            $rules[] = new LikeRule('title', $inputData['filterTitle']);

        if($inputData['filterFrom'] ?? null)
            $rules[] = new DateMoreRule('date_of_publication', $inputData['filterFrom']);

        if($inputData['filterTo'] ?? null)
            $rules[] = new DateLessRule('date_of_publication', $inputData['filterTo']);

        $rules = array_merge($rules, $this->createSortRules($inputData['sort'] ?? null, $this->sortFields));
        return $rules;
    }

    public function all(): Collection
    {
        return $this->getModel()->all();
    }

    public function paginateForUser($user_id, ?int $size = null): LengthAwarePaginator
    {
        $size = $size ?? config('app.PAGINATE_SIZE', 10);

        return $this->getModel()->query()->whereHas('authors', function (Builder $q) use($user_id){
            $q->where('user_id', $user_id);
        })->paginate($size);
    }
}
