<?php


namespace App\Repositories\Interfaces;


interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function getForCombo();
    public function getForExportList(): array;
}
