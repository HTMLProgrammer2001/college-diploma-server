<?php


namespace App\Builders;


use App\Builders\Interfaces\InternshipBuilderInterface;
use App\Models\Internship;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class InternshipBuilder implements InternshipBuilderInterface
{
    //function to fill model instance by data
    protected function fillData(Internship $internship, array $data): Model{
        if($data['from'] ?? false)
            $data['from'] = Carbon::parse($data['from'])->format('Y-m-d');

        if($data['to'] ?? false)
            $data['to'] = Carbon::parse($data['to'])->format('Y-m-d');

        $internship->fill($data);
        $internship->setUser($data['user']);
        $internship->setCategory($data['category']);

        $internship->save();
        return $internship;
    }

    //create model instance
    public function create(array $data): Model
    {
        return $this->fillData(new Internship(), $data);
    }

    //update model instance
    public function update(int $id, array $data): Model
    {
        $internship = Internship::findOrFail($id);
        return $this->fillData($internship, $data);
    }
}
