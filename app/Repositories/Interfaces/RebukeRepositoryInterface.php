<?php


namespace App\Repositories\Interfaces;


interface RebukeRepositoryInterface extends BaseRepositoryInterface
{
    public function all();

    public function paginateForUser($user_id, ?int $size = null);

    public function getUserString(int $user_id): string;
}
