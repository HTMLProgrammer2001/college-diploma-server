<?php


namespace App\Builders;


use Illuminate\Database\Eloquent\Model;

interface BuilderInterface
{
    //function to create model instance
    public function create(array $data): Model;

    //function to update model
    public function update(int $id, array $data): Model;
}
