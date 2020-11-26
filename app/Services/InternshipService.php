<?php


namespace App\Services;


use App\Builders\Interfaces\InternshipBuilderInterface;
use App\Models\Internship;
use App\Repositories\Interfaces\InternshipRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class InternshipService extends ModelService
{
    public function __construct(InternshipRepositoryInterface $rep, InternshipBuilderInterface $builder)
    {
        $this->rep = $rep;
        $this->builder = $builder;
    }

    public function getModel(): Model
    {
        return app(Internship::class);
    }

    public function all(): Collection
    {
        return $this->rep->all();
    }

    public function paginateForUser(int $user_id, ?int $size = null): LengthAwarePaginator
    {
        return $this->rep->paginateForUser($user_id, $size);
    }

    public function getUserString(Collection $internships): string
    {
        return $this->rep->getUserString($internships);
    }

    public function getInternshipHoursOf(Collection $internship): int
    {
        return $this->rep->getInternshipHoursOf($internship);
    }
}
