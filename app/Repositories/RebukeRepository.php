<?php


namespace App\Repositories;


use App\Models\Rebuke;
use App\Repositories\Interfaces\RebukeRepositoryInterface;
use App\Repositories\Rules\DateLessRule;
use App\Repositories\Rules\DateMoreRule;
use App\Repositories\Rules\EqualRule;
use App\Repositories\Rules\LikeRule;
use Illuminate\Database\Eloquent\Model;

class RebukeRepository extends BaseRepository implements RebukeRepositoryInterface
{
    private $model = Rebuke::class;
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

    public function create($data)
    {
//        if($data['date_presentation'] ?? false)
//            $data['date_presentation'] = from_locale_date($data['date_presentation']);

        $rebuke = $this->getModel()->query()->newModelInstance($data);
        $rebuke->changeActive(true);
        $rebuke->setUser($data['user']);
        $rebuke->save();

        return $rebuke;
    }

    public function update($id, $data)
    {
//        if($data['date_presentation'] ?? false)
//            $data['date_presentation'] = from_locale_date($data['date_presentation']);

        $rebuke = $this->getModel()->query()->findOrFail($id);
        $rebuke->fill($data);

        $rebuke->changeActive(true);
        $rebuke->setUser($data['user']);
        $rebuke->save();

        return $rebuke;
    }

    public function all()
    {
        return $this->getModel()->all();
    }

    public function paginateForUser($user_id, ?int $size = null)
    {
        $size = $size ?? config('app.PAGINATE_SIZE', 10);

        return $this->getModel()->query()->where('user_id', $user_id)->paginate($size);
    }

    public function getUserString(int $user_id): string
    {
        //get all rebukes
        $rebukes = $this->getModel()->query()->where('user_id', $user_id)->get();

        //parse string
        $rebukesString = $rebukes->reduce(function(string $acc, $item){
            return $acc . implode(', ', [$item->title, $item->date_presentation, $item->order]) . ';';
        }, '');

        //return info
        return $rebukesString ? $rebukesString : 'Немає інформації';
    }
}
