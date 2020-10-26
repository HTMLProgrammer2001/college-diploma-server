<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'date'];

    //relations
    public function user(){
        return $this->belongsTo(User::class);
    }

    //helpers
    public function setUser($id){
        if(!$id)
            return;

        $this->user()->associate(User::query()->find($id));
    }

    public function getUserShortName(){
        if(!$this->user)
            return;

        return $this->user->getShortName();
    }
}
