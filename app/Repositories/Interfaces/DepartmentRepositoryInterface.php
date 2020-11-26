<?php


namespace App\Repositories\Interfaces;


interface DepartmentRepositoryInterface extends BaseRepositoryInterface
{
    public function getForCombo();
    public function getForExportList();
}
