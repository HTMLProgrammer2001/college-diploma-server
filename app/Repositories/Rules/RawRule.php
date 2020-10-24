<?php


namespace App\Repositories\Rules;


use Illuminate\Database\Eloquent\Builder;

class RawRule implements RuleInterface
{
    protected $statement, $args;

    public function __construct($statement, ...$args)
    {
        $this->statement = $statement;
        $this->args = $args;
    }

    public function apply(Builder $q): Builder
    {
        return $q->whereRaw($this->statement, $this->args);
    }
}
