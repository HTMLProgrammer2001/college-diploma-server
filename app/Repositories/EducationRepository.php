<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

use App\Models\Education;
use App\Repositories\Interfaces\EducationRepositoryInterface;
use App\Repositories\Rules\EqualRule;
use App\Repositories\Rules\SortRule;

class EducationRepository extends BaseRepository implements EducationRepositoryInterface
{
    private $model = Education::class;
    private $sortFields = [
        'ID' => 'id',
        'institution' => 'institution',
        'graduateYear' => 'graduate_year',
        'qualification' => 'qualification'
    ];

    public function getModel(): Model
    {
        return app($this->model);
    }

    public function createRules(array $inputData): array
    {
        $rules = [];

        if($inputData['user_id'] ?? null)
            $rules[] = new EqualRule('user_id', $inputData['user_id']);

        if($inputData['filterQualification'] ?? null){
            if($inputData['filterQualification'] != -1){
                $qualification = Education::QUALIFICATIONS[$inputData['filterQualification']];
                $rules[] = new EqualRule('qualification', $qualification);
            }
        }

        if($inputData['filterGraduateYear'] ?? null)
            $rules[] = new EqualRule('graduate_year', $inputData['filterGraduateYear']);

        if($inputData['filterInstitution'] ?? null)
            $rules[] = new EqualRule('institution', $inputData['filterInstitution']);

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
        $education = $this->getModel()->query()->newModelInstance($data);
        $education->setUser($data['user']);
        $education->save();
    }

    public function update($id, $data)
    {
        $education = $this->getModel()->query()->findOrFail($id);
        $education->fill($data);
        $education->setUser($data['user']);
        $education->save();

        return $education;
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

    public function getUserString(int $user_id): string {
        //get  all educations
        $educations = $this->getModel()->query()->where('user_id', $user_id)->get();

        //parse string
        $educationsString = $educations->reduce(function(string $acc, $item){
            return $acc . implode(', ', [$item->institution, $item->graduate_year, $item->qualification]) . ';';
        }, '');

        //return info
        return $educationsString ? $educationsString : 'Немає інформації';
    }
}
