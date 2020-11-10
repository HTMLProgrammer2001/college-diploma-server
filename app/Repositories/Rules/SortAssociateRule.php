<?php


namespace App\Repositories\Rules;


use Illuminate\Database\Eloquent\Builder;

class SortAssociateRule implements RuleInterface
{
    private $association, $field, $direction, $select;

    public function __construct(array $association, string $select, string $field, string $direction)
    {
        $this->association = $association;
        $this->field = $field;
        $this->direction = $direction == 1 ? 'DESC' : 'ASC';
        $this->select = $select;
    }

    public function apply(Builder $q): Builder
    {
        return $q->leftJoin(...$this->association)->orderBy($this->field, $this->direction)->select($this->select);
    }
}
