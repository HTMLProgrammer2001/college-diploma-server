<?php


namespace App\Repositories\Rules;


use Illuminate\Database\Eloquent\Builder;

interface RuleInterface
{
    public function apply(Builder $q): Builder;
}
