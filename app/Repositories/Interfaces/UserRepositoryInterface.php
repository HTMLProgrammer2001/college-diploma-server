<?php


namespace App\Repositories\Interfaces;


interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function all();

    public function getForCombo();

    public function getRoles(): array;

    public function getPedagogicalTitles(): array;

    public function getForExportList(): array;

    public function getAcademicStatusList(): array;

    public function getScientificDegreeList(): array;
}
