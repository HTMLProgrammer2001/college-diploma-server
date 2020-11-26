<?php


namespace App\Builders;


use App\Builders\Interfaces\CategoryBuilderInterface;
use App\Models\Education;
use Illuminate\Database\Eloquent\Model;

class CategoryBuilder implements CategoryBuilderInterface
{
    //create model instance
    public function create(array $data): Model
    {
        $category = new Education($data);
        $category->save();

        return $category;
    }

    //update model instance
    public function update(int $id, array $data): Model
    {
        $category = Education::query()->find($id);
        $category->fill($data);
        $category->save();

        return $category;
    }
}
