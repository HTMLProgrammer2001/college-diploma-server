<?php


namespace App\Repositories\Interfaces;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface BaseRepositoryInterface
{
    public function createSortRules(?array $sort, ?array $fields): array;

    public function createRules(array $inputData): array;

    public function create($data);

    public function update($id, $data);

    public function destroy($id);

    public function getById(int $id);

    public function paginate(?int $size);

    public function filterPaginate(array $rules, ?int $size = null);

    public function filter(array $rules): Builder;

    public function filterGet(array $rules): Collection;
}
