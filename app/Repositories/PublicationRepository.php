<?php


namespace App\Repositories;


use App\Models\Publication;
use App\Repositories\Interfaces\PublicationRepositoryInterface;

use App\Repositories\Rules\DateLessRule;
use App\Repositories\Rules\DateMoreRule;
use App\Repositories\Rules\EqualRule;
use App\Repositories\Rules\HasAssociateRule;
use App\Repositories\Rules\LikeRule;
use App\Repositories\Rules\SortRule;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PublicationRepository extends BaseRepository implements PublicationRepositoryInterface
{
    private $model = Publication::class;
    private $sortFields = [
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

        if(is_array($inputData['sort'] ?? null)){
            foreach ($inputData['sort'] as $sortRuleStr){
                $sortRule = json_decode($sortRuleStr);

                if(!in_array($sortRule->field, array_keys($this->sortFields)))
                    continue;

                $rules[] = new SortRule($this->sortFields[$sortRule->field], $sortRule->direction);
            }
        }

        return $rules;
    }

    public function create($data)
    {
        if($data['date_of_publication'] ?? false)
            $data['date_of_publication'] = from_locale_date($data['date_of_publication']);

        $publication = $this->getModel()->query()->newModelInstance($data);
        $publication->fill($data);
        $publication->save();

        $publication->setAuthors($data['authors']);
        $publication->save();

        return $publication;
    }

    public function update($id, $data)
    {
        if($data['date_of_publication'] ?? false)
            $data['date_of_publication'] = from_locale_date($data['date_of_publication']);

        $publication = $this->getModel()->query()->findOrFail($id);
        $publication->fill($data);
        $publication->save();

        $publication->setAuthors($data['authors']);
        $publication->save();

        return $publication;
    }

    public function all()
    {
        return $this->getModel()->all();
    }

    public function paginateForUser($user_id, ?int $size = null)
    {
        $size = $size ?? config('app.PAGINATE_SIZE', 10);

        return $this->getModel()->query()->whereHas('authors', function (Builder $q) use($user_id){
            $q->where('user_id', $user_id);
        })->paginate($size);
    }
}
