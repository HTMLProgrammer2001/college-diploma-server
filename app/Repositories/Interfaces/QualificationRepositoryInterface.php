<?php


namespace App\Repositories\Interfaces;


interface QualificationRepositoryInterface extends BaseRepositoryInterface
{
    public function all();
    public function paginateForUser($user_id, ?int $size = null);
    public function getLastQualificationDateOf(int $user_id);
    public function getNextQualificationDateOf(int $user_id);
    public function getQualificationNameOf(int $user_id);
    public function getLastQualificationOf(int $user_id);
}
