<?php


namespace App\Builders;


use App\Builders\Interfaces\HonorBuilderInterface;
use App\Models\Honor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class HonorBuilder implements HonorBuilderInterface
{
    //function to fill model instance by data
    protected function fillData(Honor $honor, array $data): Model{
        if($data['date_presentation'] ?? false)
            $data['date_presentation'] = Carbon::parse($data['date_presentation'])->format('Y-m-d');

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
