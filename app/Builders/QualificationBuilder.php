<?php


namespace App\Builders;


use App\Models\Qualification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class QualificationBuilder implements BuilderInterface
{
    //function to fill model instance by data
    protected function fillData(Qualification $qualification, array $data): Model{
        $qualification->fill($data);
        $qualification->setUser($data['user']);

        $qualification->save();
        return $qualification;
    }

    //create model instance
    public function create(array $data): Model
    {
        return $this->fillData(new Qualification(), $data);
    }

    //update model instance
    public function update(int $id, array $data): Model
    {
        $qualification = Qualification::findOrFail($id);
        return $this->fillData($qualification, $data);
    }
}
