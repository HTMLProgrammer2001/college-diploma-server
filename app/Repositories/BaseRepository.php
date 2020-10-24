<?php


namespace App\Repositories;


use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    //method that return class of repository model
    abstract public function getModel(): Model;

    public function destroy($id)
    {
        //destroy model
        return $this->getModel()->destroy($id);
    }

    public function getById(int $id)
    {
        //find model by id
        return $this->getModel()->find($id);
    }

    public function paginate(?int $size = null)
    {
        //return pagination without filters
        return $this->filterPaginate([], $size);
    }

    public function filter(array $rules): Builder{
        //create query builder
        $query = $this->getModel()->query();

        //apply all rules
        foreach ($rules as $rule)
            $query = $rule->apply($query);

        return $query;
    }

    public function filterPaginate(array $rules, ?int $size = null)
    {
        //filter query
        $query = $this->filter($rules);

        //set size of pagination
        $size = $size ?? config('app.PAGINATE_SIZE', 10);

        //return pagination
        return $query->paginate($size);
    }

    public function filterGet(array $rules): Collection{
        //filter query
        $query = $this->filter($rules);

        return $query->get();
    }
}
