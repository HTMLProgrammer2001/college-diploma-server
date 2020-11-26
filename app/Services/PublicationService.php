<?php


namespace App\Services;


use App\Builders\Interfaces\PublicationBuilderInterface;
use App\Models\Publication;
use App\Repositories\Interfaces\PublicationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PublicationService extends ModelService
{
    public function __construct(PublicationRepositoryInterface $rep, PublicationBuilderInterface $builder)
    {
        $this->rep = $rep;
        $this->builder = $builder;
    }

    public function getModel(): Model
    {
        return app(Publication::class);
    }

    public function all(): Collection
    {
        return $this->rep->all();
    }

    public function paginateForUser(int $user_id, ?int $size = null): LengthAwarePaginator
    {
        return $this->rep->paginateForUser($user_id, $size);
    }
}
