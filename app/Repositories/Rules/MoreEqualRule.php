<?php


namespace App\Repositories\Rules;


use Illuminate\Database\Eloquent\Builder;

class MoreEqualRule implements RuleInterface
{
    protected $field, $value;

    public function __construct(string $field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    public function apply(Builder $q): Builder
    {
        return $q->where($this->field, '>=', $this->value);
    }
}
