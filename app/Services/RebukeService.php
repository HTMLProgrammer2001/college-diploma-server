<?php


namespace App\Services;


use App\Builders\Interfaces\RebukeBuilderInterface;
use App\Models\Rebuke;
use App\Repositories\Interfaces\RebukeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class RebukeService extends ModelService
{
    public function __construct(RebukeRepositoryInterface $rep, RebukeBuilderInterface $builder)
    {
        $this->rep = $rep;
        $this->builder = $builder;
    }

    public function getModel(): Model
    {
        return app(Rebuke::class);
    }

    public function all(): Collection
    {
        return $this->rep->all();
    }

    public function paginateForUser(int $user_id, ?int $size = null): LengthAwarePaginator
    {
        return $this->rep->paginateForUser($user_id, $size);
    }

    public function getUserString(int $userID): ?string
    {
        return $this->rep->getUserString($userID);
    }
}
