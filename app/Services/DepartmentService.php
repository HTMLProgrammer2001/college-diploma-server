<?php


namespace App\Services;


use App\Builders\Interfaces\DepartmentBuilderInterface;
use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DepartmentService extends ModelService
{
    public function __construct(DepartmentRepositoryInterface $rep, DepartmentBuilderInterface $builder)
    {
        $this->rep = $rep;
        $this->builder = $builder;
    }

    public function getModel(): Model
    {
        return app(Department::class);
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
