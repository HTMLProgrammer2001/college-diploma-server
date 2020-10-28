<?php


namespace App\Repositories\Interfaces;


interface CommissionRepositoryInterface extends BaseRepositoryInterface
{
    public function getForCombo();

    public function getForExportList();
}
