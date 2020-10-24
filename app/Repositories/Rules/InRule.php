<?php


namespace App\Repositories\Rules;


use Illuminate\Database\Eloquent\Builder;

class InRule implements RuleInterface
{
    protected $field, $values;

    public function __construct($field, array $values)
    {
        $this->field = $field;
        $this->values = $values;
    }

    public function apply(Builder $q): Builder
    {
        return $q->whereIn($this->field, $this->values);
    }
}
