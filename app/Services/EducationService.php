<?php


namespace App\Services;


use App\Builders\Interfaces\EducationBuilderInterface;
use App\Models\Education;
use App\Repositories\Interfaces\EducationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EducationService extends ModelService
{
    public function __construct(EducationRepositoryInterface $rep, EducationBuilderInterface $builder)
    {
        $this->rep = $rep;
        $this->builder = $builder;
    }

    public function getModel(): Model
    {
        return app(Education::class);
    }

    public function all(): Collection
    {
        return $this->rep->all();
    }

    public function paginateForUser(int $user_id, ?int $size = null): LengthAwarePaginator
    {
        return $this->rep->paginateForUser($user_id, $size);
    }

    public function getUserString(int $userID): string
    {
        return $this->rep->getUserString($userID);
    }
}
