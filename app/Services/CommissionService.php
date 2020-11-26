<?php


namespace App\Services;


use App\Builders\Interfaces\CommissionBuilderInterface;
use App\Models\Commission;
use App\Repositories\Interfaces\CommissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CommissionService extends ModelService
{
    public function __construct(CommissionRepositoryInterface $rep, CommissionBuilderInterface $builder)
    {
        $this->rep = $rep;
        $this->builder = $builder;
    }

    public function getModel(): Model
    {
        return app(Commission::class);
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
