<?php


namespace App\Services;


use App\Builders\Interfaces\UserBuilderInterface;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserService extends ModelService
{
    private $avatarService;

    public function __construct(UserRepositoryInterface $rep, UserBuilderInterface $builder,
                                PhotoUploader $avatarService)
    {
        $this->rep = $rep;
        $this->builder = $builder;
        $this->avatarService = $avatarService;
    }

    public function getModel(): Model
    {
        return app(User::class);
    }

    public function all(): Collection
    {
        return $this->rep->all();
    }

    public function getForCombo()
    {
        return $this->rep->getForCombo();
    }

    public function getForExportList()
    {
        return $this->rep->getForExportList();
    }

    public function getAcademicStatusList(): array{
        return $this->rep->getAcademicStatusList();
    }

    public function getScientificDegreeList(): array{
        return $this->rep->getScientificDegreeList();
    }

    public function getRoles(): array
    {
        return $this->rep->getRoles();
    }

    public function getPedagogicalTitles(): array
    {
        return $this->rep->getPedagogicalTitles();
    }

    public function destroy($id): bool
    {
        $user = $this->getModel()->query()->findOrFail($id);
        $this->avatarService->deleteAvatar($user->avatar);

        return $this->getModel()->destroy($id);
    }
}
