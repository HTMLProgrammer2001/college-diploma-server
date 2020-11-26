<?php


namespace App\Repositories;

use App\Repositories\Rules\LessEqualRule;
use App\Repositories\Rules\LikeRule;
use App\Repositories\Rules\MoreEqualRule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use App\Models\Education;
use App\Repositories\Interfaces\EducationRepositoryInterface;
use App\Repositories\Rules\EqualRule;

class EducationRepository extends BaseRepository implements EducationRepositoryInterface
{
    private $model = Education::class;
    protected $sortFields = [
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

        if($inputData['filterUser'] ?? null)
            $rules[] = new EqualRule('user_id', $inputData['filterUser']);

        if(($inputData['filterQualification'] ?? null) != null){
            if($inputData['filterQualification'] != -1){
                $qualification = Education::QUALIFICATIONS[$inputData['filterQualification']];
                $rules[] = new LikeRule('qualification', $qualification);
            }
        }

        if($inputData['filterSpecialty'] ?? null)
            $rules[] = new LikeRule('specialty', $inputData['filterSpecialty']);

        if($inputData['filterGraduateYear'] ?? null)
            $rules[] = new EqualRule('graduate_year', $inputData['filterGraduateYear']);

        if($inputData['filterGraduateFrom'] ?? null)
            $rules[] = new MoreEqualRule('graduate_year', $inputData['filterGraduateFrom']);

        if($inputData['filterGraduateTo'] ?? null)
            $rules[] = new LessEqualRule('graduate_year', $inputData['filterGraduateTo']);

        if($inputData['filterInstitution'] ?? null)
            $rules[] = new LikeRule('institution', $inputData['filterInstitution']);

        $rules = array_merge($rules, $this->createSortRules($inputData['sort'] ?? null, $this->sortFields));
        return $rules;
    }

    public function all(): Collection
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
