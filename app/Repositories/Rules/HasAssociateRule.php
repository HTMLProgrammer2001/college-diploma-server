<?php


namespace App\Repositories\Rules;


use Illuminate\Database\Eloquent\Builder;

class HasAssociateRule implements RuleInterface
{
    protected $association, $validator;

    public function __construct(string $association, RuleInterface $validator)
    {
        $this->validator = $validator;
        $this->association = $association;
    }

    public function apply(Builder $q): Builder
    {
        return $q->whereHas($this->association, function($q){
           $this->validator->apply($q);
        });
    }
}
