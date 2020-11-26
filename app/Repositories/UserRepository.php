<?php


namespace App\Repositories;


use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Rules\EqualRule;
use App\Repositories\Rules\LikeRule;
use App\Services\PhotoUploader;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    private $avatarService;
    private $model = User::class;
    private $sortFields = [
        'ID' => 'id',
        'name' => 'fullName',
        'email' => 'email'
    ];

    public function __construct(PhotoUploader $avatarService)
    {
        $this->avatarService = $avatarService;
    }

    public function createRules(array $inputData): array
    {
        $rules = [];

        if($inputData['filterName'] ?? null)
            $rules[] = new LikeRule('fullName', $inputData['filterName']);

        if($inputData['filterEmail'] ?? null)
            $rules[] = new LikeRule('email', $inputData['filterEmail']);

        if($inputData['filterCommission'] ?? null)
            $rules[] = new EqualRule('commission_id', $inputData['filterCommission']);

        if($inputData['filterDepartment'] ?? null)
            $rules[] = new EqualRule('department_id', $inputData['filterDepartment']);

        if($inputData['filterRank'] ?? null)
            $rules[] = new EqualRule('rank_id', $inputData['filterRank']);

        if($inputData['filterTitle'] ?? null)
            $rules[] = new EqualRule('pedagogical_title', $inputData['filterTitle']);

        if($inputData['filterCategory'] ?? null) {
            //$rules[] = new EqualRule('pedagogical_title', $inputData['filterTitle']);
        }

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

    public function getForCombo(): Collection
    {
        return $this->getModel()->all('id', 'name', 'surname', 'patronymic');
    }

    public function getForExportList(): array
    {
        $users = $this->getModel()->all('id', 'fullName')->toArray();
        return to_export_list($users);
    }
}
