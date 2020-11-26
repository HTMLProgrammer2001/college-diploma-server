<?php


namespace App\Services;


use App\Builders\Interfaces\RankBuilderInterface;
use App\Models\Rank;
use App\Repositories\Interfaces\RankRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class RankService extends ModelService
{
    public function __construct(RankRepositoryInterface $rep, RankBuilderInterface $builder)
    {
        $this->rep = $rep;
        $this->builder = $builder;
    }

    public function getModel(): Model
    {
        return app(Rank::class);
    }

    public function all(): Collection
    {
        return $this->rep->all();
    }

    public function getForCombo(): Collection
    {
        return $this->rep->getForCombo();
    }

    public function getForExportList(): array
    {
        return $this->rep->getForExportList();
    }
}
