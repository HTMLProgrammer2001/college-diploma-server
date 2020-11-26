<?php


namespace App\Builders;


use App\Models\Honor;
use Illuminate\Database\Eloquent\Model;

class HonorBuilder implements BuilderInterface
{
    //function to fill model instance by data
    protected function fillData(Honor $honor, array $data): Model{
        $honor->fill($data);
        $honor->setUser($data['user']);
        $honor->changeActive($data['activity'] ?? true);

        $honor->save();
        return $honor;
    }

    //create model instance
    public function create(array $data): Model
    {
        return $this->fillData(new Honor(), $data);
    }

    //update model instance
    public function update(int $id, array $data): Model
    {
        $honor = Honor::findOrFail($id);
        return $this->fillData($honor, $data);
    }
}
