<?php


namespace App\Repositories\Rules;


use Illuminate\Database\Eloquent\Builder;

class SortRule implements RuleInterface
{
    private $field, $direction;

    public function __construct($field, $direction)
    {
        $this->field = $field;
        $this->direction = $direction == 1 ? 'DESC' : 'ASC';
    }

    public function apply(Builder $q): Builder
    {
        return $q->orderBy($this->field, $this->direction);
    }
}
