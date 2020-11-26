<?php


namespace App\Repositories\Interfaces;


interface PublicationRepositoryInterface extends BaseRepositoryInterface
{
    public function all();
    public function paginateForUser($user_id, ?int $size = null);
}
