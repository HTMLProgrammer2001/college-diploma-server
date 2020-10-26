<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rebuke extends Model
{
    use HasFactory;

    public $fillable = ['order', 'title', 'date_presentation'];

    //relations
    public function user(){
        return $this->belongsTo(User::class);
    }

    //helpers
    public function getUserName(){
        if(!$this->user)
            return null;

        return $this->user->getShortName();
    }

    public function getUserID(){
        if(!$this->user)
            return null;

        return $this->user->id;
    }

    public function changeActive($value){
        $this->active = !!$value;
    }

    public function setUser($user_id){
        if(!$user_id)
            return;

        $this->user()->associate(User::query()->find($user_id));
    }
}
