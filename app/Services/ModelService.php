<?php


namespace App\Services;


use App\Builders\BuilderInterface;
use App\Repositories\BaseRepository;
use App\Repositories\Rules\RuleInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

//Classes that using as "Facade" for model
abstract class ModelService
{
    /**
     * @var BaseRepository
     */
    protected $rep;

    /**
     * @var BuilderInterface
     */
    protected $builder;

    abstract protected function getModel(): Model;

    public function create(array $data): Model{
        return $this->builder->create($data);
    }

    /**
     * @param int $id ID of model to update
     * @param array $data Data to update
     * @return Model Updated model
     */
    public function update(int $id, array $data): Model{
        return $this->builder->update($id, $data);
    }

    /**
     * Setter of repository property
     * @param BaseRepository $repository
     */
    public function setRepository(BaseRepository $repository){
        $this->rep = $repository;
    }

    /**
     * Setter of builder property
     * @param BuilderInterface $builder
     */
    public function setBuilder(BuilderInterface $builder){
        $this->builder = $builder;
    }

    /**
     * @param int $id Model id to delete
     * @return bool
     */
    public function destroy(int $id): bool {
        return $this->getModel()->destroy($id);
    }

    /**
     * @param array|null $sort Income rules to sort
     * @param array|null $fields
     * @return RuleInterface[]
     */
    public function createSortRules(?array $sort, ?array $fields): array{
        return $this->rep->createSortRules($sort, $fields);
    }

    /**
     * @param int $id ID of model
     * @return mixed
     */
    public function getById(int $id)
    {
        return $this->rep->getById($id);
    }

    /**
     * @param int|null $size Size of page to paginate
     * @return LengthAwarePaginator
     */
    public function paginate(?int $size = null)
    {
        return $this->rep->paginate($size);
    }

    /**
     * @param RuleInterface[] $rules Rules of array to filter and sort
     * @return Builder
     */
    public function filter(array $rules)
    {
        return $this->rep->filter($rules);
    }

    /**
     * @param array $rules Rules to filter and sort
     * @param int|null $size Size of page
     * @return LengthAwarePaginator
     */
    public function filterPaginate(array $rules, ?int $size)
    {
        return $this->rep->filterPaginate($rules, $size);
    }

    /**
     * @param array $rules Rules to sort
     * @return Collection
     */
    public function filterGet(array $rules)
    {
        return $this->rep->filterGet($rules);
    }

    /**
     * @param array $data Input data
     * @return RuleInterface[]
     */
    public function createRules(array $data)
    {
        return $this->rep->createRules($data);
    }
}
