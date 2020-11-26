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
        $user->generatePassword($data['password']);

        //relationships
        $user->setDepartment($data['department']);
        $user->setCommission($data['commission']);

        if($data['rank'] ?? false)
            $user->setRank($data['rank']);

        if($data['role'] ?? false && $update)
            $user->role = $data['role'];

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
