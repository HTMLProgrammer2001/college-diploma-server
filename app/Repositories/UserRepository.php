<?php


namespace App\Repositories;


use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Rules\EqualRule;
use App\Repositories\Rules\LikeRule;
use App\Services\PhotoUploader;
use App\Models\User;
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

    public function create($data)
    {
        if($data['birthday'] ?? false)
            $data['birthday'] = from_locale_date($data['birthday']);

        $user = $this->getModel()->query()->newModelInstance($data);

        //generate secret values
        $user->generatePassword($data['password']);

        //relationships
        $user->setDepartment($data['department']);
        $user->setCommission($data['commission']);

        if($data['rank'] ?? false)
            $user->setRank($data['rank']);

        $user->avatar = $this->avatarService->uploadAvatar($data['avatar'] ?? null);
        $user->save();

        return $user;
    }

    public function update($id, $data)
    {
        if($data['birthday'] ?? false)
            $data['birthday'] = from_locale_date($data['birthday']);

        $user = $this->getModel()->query()->findOrFail($id);
        $user->fill($data);

        //generate secret values
        $user->generatePassword($data['password'] ?? false);
        $user->cryptPassport($data['passport'] ?? false);
        $user->cryptCode($data['code'] ?? false);

        //relationships
        $user->setDepartment($data['department'] ?? false);
        $user->setCommission($data['commission'] ?? false);
        $user->setRank($data['rank'] ?? false);

        //set new avatar
        $this->avatarService->deleteAvatar($user->avatar ?? false);
        $user->avatar = $this->avatarService->uploadAvatar($data['avatar'] ?? false);

        if($data['role'] ?? false)
            $user->role = $data['role'];

        $user->save();
    }

    public function destroy($id)
    {
        $user = $this->getModel()->query()->findOrFail($id);
        $this->avatarService->deleteAvatar($user->avatar);

        return $this->getModel()->destroy($id);
    }

    public function all()
    {
        return $this->getModel()->all();
    }

    public function getForCombo()
    {
        return $this->getModel()->all('id', 'name', 'surname', 'patronymic');
    }

    public function getRoles(): array
    {
        return $this->getModel()->getRolesArray();
    }

    public function getPedagogicalTitles(): array
    {
        return $this->getModel()->getPedagogicalTitles();
    }

    public function getForExportList(): array
    {
        $users = $this->getModel()->all('id', 'fullName')->toArray();
        return to_export_list($users);
    }

    public function getAcademicStatusList(): array{
        return [
            'Кандидат наук',
            'Доктор наук'
        ];
    }

    public function getScientificDegreeList(): array{
        return [
            'Доцент',
            'Старший дослідник',
            'Професор'
        ];
    }
}
