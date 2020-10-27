<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    public $fillable = ['title', 'hours', 'credits', 'code', 'from', 'to', 'place'];

    //relations
    public function category(){
        return $this->belongsTo(InternCategory::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    //helpers
    public function setCategory($categoryId){
        if(!$categoryId)
            return;

        $this->category()->associate(InternCategory::query()->find($categoryId));
    }

    public function setUser($userId){
        if(!$userId)
            return;

        $this->user()->associate(User::query()->find($userId));
    }

    public function getUserName(){
        if($this->user)
            return $this->user->getShortName();

        return null;
    }

    public function getCategoryName(){
        if($this->category)
            return $this->category->name;

        return 'Не встановлено';
    }

    public function getUserID(){
        if($this->user)
            return $this->user->id;
    }

    public function getCategoryID(){
        if($this->category)
            return $this->category->id;
    }

    public function getUserShortName(){
        if($this->user)
            return $this->user->getShortName();
    }
}
