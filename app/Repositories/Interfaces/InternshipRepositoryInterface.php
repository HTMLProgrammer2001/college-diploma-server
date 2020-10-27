<?php


namespace App\Repositories\Interfaces;


use Illuminate\Support\Collection;

interface InternshipRepositoryInterface extends BaseRepositoryInterface
{
    public function all();

    public function getInternshipHoursOf($internships): int;

    public function paginateForUser(int $user_id, ?int $size = null);

    public function getUserString(Collection $internships): string;

    public function getInternshipsFor(int $user_id);
}
