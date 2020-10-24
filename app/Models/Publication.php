<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    public $fillable = ['title', 'description', 'another_authors', 'url',
        'publisher', 'date_of_publication'];

    //relations
    public function authors(){
        return $this->belongsToMany(User::class, 'users_publications', 'publication_id');
    }

    //helpers
    public function setAuthors($ids){
        if(!$ids || !sizeof($ids))
            return;

        $this->authors()->sync($ids);
        $this->save();
    }

    public function getAuthorsString(): string {
        $names = [];

        foreach ($this->authors as $author)
            $names[] = $author->getShortName();

        $authorsStr = implode(', ', $names);

        if($this->another_authors)
            $authorsStr .= ', ' . $this->another_authors;

        return $authorsStr;
    }
}
