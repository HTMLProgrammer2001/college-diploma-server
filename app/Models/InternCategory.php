<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternCategory extends Model
{
    use HasFactory;

    protected $table = 'internship_categories';

    public $fillable = ['name'];

    //relations
    public function internships(){
        return $this->hasMany(Internship::class);
    }
}
