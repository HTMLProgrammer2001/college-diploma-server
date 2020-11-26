<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';
    public $fillable = ['institution', 'graduate_year', 'specialty'];

    //relations
    public function user(){
        return $this->belongsTo(User::class);
    }

    //helpers
    public function setUser($id){
        if(!$id)
            return;

        $this->user()->associate($id);
    }

    public function getUserID(){
        if(!$this->user)
            return;

        return $this->user->id;
    }

    public function getUserName(){
        if(!$this->user)
            return;

        return $this->user->getShortName();
    }

    public function setQualification(int $qualification){
        if($qualification >= 0 && $qualification < sizeof(\Constants::$qualificationNames))
            $this->qualification = $qualification;
    }

    public function getQualification(): string {
        return \Constants::$qualificationNames[$this->qualification];
    }
}
