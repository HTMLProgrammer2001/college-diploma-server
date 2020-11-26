<?php


namespace App\Repositories\Interfaces;


interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function all();
    public function getForCombo();
}
