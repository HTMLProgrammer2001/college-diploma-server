<?php


namespace App\Services;


use App\Builders\Interfaces\CategoryBuilderInterface;
use App\Models\InternCategory;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CategoryService extends ModelService
{
    public function __construct(CategoryRepositoryInterface $rep, CategoryBuilderInterface $builder)
    {
        $this->rep = $rep;
        $this->builder = $builder;
    }

    public function getModel(): Model
    {
        return app(InternCategory::class);
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
