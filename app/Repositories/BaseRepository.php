<?php


namespace App\Repositories;


use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Rules\SortAssociateRule;
use App\Repositories\Rules\SortRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements BaseRepositoryInterface
{
    //method that return class of repository model
    abstract public function getModel(): Model;

    public function createSortRules(?array $sort, ?array $fields): array
    {
        $sortRules = [];

        if(is_array($sort ?? null)){
            foreach ($sort as $sortRuleStr){
                // parse sort rule
                $sortRule = json_decode($sortRuleStr);

                //we have not info about sort by this field
                if(!in_array($sortRule->field, array_keys($fields)))
                    continue;

                if(is_array($fields[$sortRule->field])){
                    //this is complex sort by relation
                    $associate = $fields[$sortRule->field]['associate'];
                    $field = $fields[$sortRule->field]['field'];
                    $select = $fields[$sortRule->field]['select'];

                    $sortRules[] = new SortAssociateRule($associate, $select, $field, $sortRule->direction);
                }
                else {
                    //this is simple sort by field
                    $sortRules[] = new SortRule($fields[$sortRule->field], $sortRule->direction);
                }
            }
        }

        return $sortRules;
    }

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

    public function filterPaginate(array $rules, ?int $size = null): LengthAwarePaginator
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
