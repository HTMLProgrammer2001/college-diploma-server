<?php


namespace App\Repositories\Interfaces;


interface RankRepositoryInterface extends BaseRepositoryInterface
{
    public function all();
    public function getForCombo();
    public function getForExportList();
}
