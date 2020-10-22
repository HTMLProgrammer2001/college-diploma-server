<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $fillable = ['name'];

    //relation
    public function users(){
        return $this->hasMany(User::class);
    }
}
