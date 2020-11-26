<?php


namespace App\Services;


use App\Builders\BuilderInterface;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

abstract class ModelService
{
    protected $rep;
    protected $builder;

    abstract protected function getModel(): Model;

    public function create(array $data): Model{
        return $this->builder->create($data);
    }

    public function update(int $id, array $data): Model{
        return $this->builder->update($id, $data);
    }

    public function setRepository(BaseRepository $repository){
        $this->rep = $repository;
    }

    public function setBuilder(BuilderInterface $builder){
        $this->builder = $builder;
    }

    public function destroy($id): bool {
        return $this->getModel()->destroy($id);
    }

    public function createSortRules(?array $sort, ?array $fields): array{
        return $this->rep->createSortRules($sort, $fields);
    }
}
