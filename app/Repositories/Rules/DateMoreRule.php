<?php


namespace App\Repositories\Rules;


use Illuminate\Database\Eloquent\Builder;

class DateMoreRule implements RuleInterface
{
    protected $field, $value;

    public function __construct($field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    public function apply(Builder $q): Builder
    {
        return $q->whereDate($this->field, '>', $this->value);
    }
}
