<?php


namespace App\Repositories;


use App\Models\Internship;
use App\Repositories\Interfaces\InternshipRepositoryInterface;
use App\Repositories\Interfaces\QualificationRepositoryInterface;

use App\Repositories\Rules\DateLessRule;
use App\Repositories\Rules\DateMoreRule;
use App\Repositories\Rules\EqualRule;
use App\Repositories\Rules\LessEqualRule;
use App\Repositories\Rules\LikeRule;
use App\Repositories\Rules\MoreEqualRule;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class InternshipRepository extends BaseRepository implements InternshipRepositoryInterface
{
    private $qualificationRep, $model = Internship::class;
    private $sortFields = [
        'ID' => 'id',
        'hours' => 'hours',
        'to' => 'to',
        'theme' => 'title',
        'user' => [
            'associate' => ['users', 'users.id', '=', 'internships.user_id'],
            'field' => 'fullName',
            'select' => 'internships.*'
        ],
        'category' => [
            'associate' => ['internship_categories', 'internship_categories.id', '=', 'internships.category_id'],
            'field' => 'name',
            'select' => 'internships.*'
        ]
    ];

    public function __construct(QualificationRepositoryInterface $qualificationRep)
    {
        $this->qualificationRep = $qualificationRep;
    }

    public function createRules(array $inputData): array
    {
        $rules = [];

        if($inputData['user_id'] ?? null)
            $rules[] = new EqualRule('user_id', $inputData['user_id']);

        if($inputData['filterCategory'] ?? null && $inputData['filterCategory'] != -1)
            $rules[] = new EqualRule('category_id', $inputData['filterCategory']);

        if($inputData['filterUser'] ?? null && $inputData['filterUser'] != -1)
            $rules[] = new EqualRule('user_id', $inputData['filterUser']);

        if($inputData['filterFrom'] ?? null)
            $rules[] = new DateMoreRule('to', $inputData['filterFrom']);

        if($inputData['filterTo'] ?? null)
            $rules[] = new DateLessRule('to', $inputData['filterTo']);

        if($inputData['filterMoreHours'] ?? null)
            $rules[] = new MoreEqualRule('hours', $inputData['filterMoreHours']);

        if($inputData['filterLessHours'] ?? null)
            $rules[] = new LessEqualRule('hours', $inputData['filterLessHours']);

        if($inputData['filterTheme'] ?? null)
            $rules[] = new LikeRule('title', $inputData['filterTheme']);

        $rules = array_merge($rules, $this->createSortRules($inputData['sort'] ?? null, $this->sortFields));
        return $rules;
    }

    public function getModel(): Model
    {
        return app($this->model);
    }

    public function create($data)
    {
        if($data['from'] ?? false)
            $data['from'] = Carbon::parse($data['from'])->format('Y-m-d');

        if($data['to'] ?? false)
            $data['to'] = Carbon::parse($data['to'])->format('Y-m-d');

        $internship = $this->getModel()->query()->newModelInstance($data);
        $internship->setCategory($data['category']);
        $internship->setUser($data['user']);

        $internship->save();

        return $internship;
    }

    public function update($id, $data)
    {
        if($data['from'] ?? false)
            $data['from'] = Carbon::parse($data['from'])->format('Y-m-d');

        if($data['to'] ?? false)
            $data['to'] = Carbon::parse($data['to'])->format('Y-m-d');

        $internship = $this->getModel()->query()->findOrFail($id);
        $internship->fill($data);

        $internship->setCategory($data['category']);
        $internship->setUser($data['user']);

        $internship->save();

        return $internship;
    }

    public function all(){
        return $this->getModel()->all();
    }

    public function getInternshipHoursOf($internships): int
    {
        //get hours sum from last qualification update
        $hours = $internships->sum('hours');
        return $hours;
    }

    public function paginateForUser(int $user_id, ?int $size = null)
    {
        $size = $size ?? config('app.PAGINATE_SIZE', 10);

        return $this->getModel()->query()->where('user_id', $user_id)->paginate($size);
    }

    public function getUserString(Collection $internships): string {
        //parse string
        $internshipsString = $internships->reduce(function(string $acc, Internship $item){
            return $acc . implode(', ', [$item->title, $item->from,
                    $item->to, $item->place, $item->getCategoryName(),
                    $item->hours . ' годин']) . ';';
        }, '');

        //return info
        return $internshipsString ? $internshipsString : 'Немає інформації';
    }

    public function getInternshipsFor(int $user_id){
        //get date of last qualification update of this user
        $from = $this->qualificationRep->getLastQualificationDateOf($user_id);

        //set default value
        if(!$from)
            $from = '1970-01-01';

        return $this->getModel()->query()->where('user_id', $user_id)
            ->whereDate('to', '>', $from)->with('category')->get();
    }
}
