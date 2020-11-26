<?php


namespace App\Services;


use App\Builders\Interfaces\QualificationBuilderInterface;
use App\Models\Qualification;
use App\Repositories\Interfaces\QualificationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class QualificationService extends ModelService
{
    public function __construct(QualificationRepositoryInterface $rep, QualificationBuilderInterface $builder)
    {
        $this->rep = $rep;
        $this->builder = $builder;
    }

    public function getModel(): Model
    {
        return app(Qualification::class);
    }

    public function all(): Collection
    {
        return $this->rep->all();
    }

    public function paginateForUser(int $user_id, ?int $size = null): LengthAwarePaginator
    {
        return $this->rep->paginateForUser($user_id, $size);
    }

    public function getQualificationNames(): array
    {
        return $this->rep->getQualificationNames();
    }

    public function getLastQualificationDateOf(int $userID): ?string
    {
        return $this->rep->getLastQualificationDateOf($userID);
    }

    public function getNextQualificationDateOf(int $userID): string
    {
        return $this->rep->getNextQualificationDateOf($userID);
    }

    public function getQualificationNameOf(int $userID): ?string
    {
        return $this->rep->getQualificationNameOf($userID);
    }

    public function getLastQualificationOf(int $userID)
    {
        return $this->rep->getLastQualificationOf($userID);
    }
}
