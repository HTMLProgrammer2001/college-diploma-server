<?php


namespace App\Builders;


use App\Builders\Interfaces\EducationBuilderInterface;
use App\Models\Education;
use Illuminate\Database\Eloquent\Model;

class EducationBuilder implements EducationBuilderInterface
{
    //function to fill model instance by data
    protected function fillData(Education $education, array $data): Model{
        $education->fill($data);
        $education->setUser($data['user']);

        if($data['qualification'])
            $education->setQualification($data['qualification']);

        $education->save();
        return $education;
    }

    //create model instance
    public function create(array $data): Model
    {
        return $this->fillData(new Education(), $data);
    }

    //update model instance
    public function update(int $id, array $data): Model
    {
        $education = Education::findOrFail($id);
        return $this->fillData($education, $data);
    }
}
