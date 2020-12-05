<?php


namespace App\Builders;


use App\Builders\Interfaces\UserBuilderInterface;
use App\Models\User;
use App\Services\PhotoUploader;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserBuilder implements UserBuilderInterface
{
    private $avatarService;

    public function __construct(PhotoUploader $uploader)
    {
        $this->avatarService = $uploader;
    }

    //function to fill model instance by data
    protected function fillData(User $user, array $data, bool $update = false): Model{
        if($data['birthday'] ?? false)
            $data['birthday'] = Carbon::parse($data['birthday'])->format('Y-m-d');

        //generate secret values
        if($data['password'] ?? false)
            $user->generatePassword($data['password']);

        //relationships
        if($data['department'] ?? false)
            $user->setDepartment($data['department']);

        if($data['commission'] ?? false)
            $user->setCommission($data['commission']);

        if($data['rank'] ?? false)
            $user->setRank($data['rank']);

        if($data['role'] ?? false && $update)
            $user->setRole($data['role']);

        if($data['academic_status'] ?? false)
            $user->setAcademicStatus($data['academic_status']);

        if($data['pedagogical_title'] ?? false)
            $user->setTitle($data['pedagogical_title']);

        if($data['scientific_degree'] ?? false)
            $user->setScientificDegree($data['scientific_degree']);

        $user->fill($data);

        if($update)
            $this->avatarService->deleteAvatar($user->avatar ?? false);

        $user->avatar = $this->avatarService->uploadAvatar($data['avatar'] ?? null);
        $user->save();

        return $user;
    }

    //create model instance
    public function create(array $data): Model
    {
        return $this->fillData(new User(), $data);
    }

    //update model instance
    public function update(int $id, array $data): Model
    {
        $user = User::findOrFail($id);
        return $this->fillData($user, $data, true);
    }
}
