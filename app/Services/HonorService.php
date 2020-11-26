<?php


namespace App\Services;


use App\Builders\Interfaces\HonorBuilderInterface;
use App\Models\Honor;
use App\Repositories\Interfaces\HonorRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class HonorService extends ModelService
{
    public function __construct(HonorRepositoryInterface $rep, HonorBuilderInterface $builder)
    {
        $this->rep = $rep;
        $this->builder = $builder;
    }

    public function getModel(): Model
    {
        return app(Honor::class);
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
