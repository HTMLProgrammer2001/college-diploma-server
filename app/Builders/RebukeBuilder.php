<?php


namespace App\Builders;


use App\Models\Rebuke;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RebukeBuilder implements BuilderInterface
{
    //function to fill model instance by data
    protected function fillData(Rebuke $rebuke, array $data): Model{
        if($data['date_presentation'] ?? false)
            $data['date_presentation'] = Carbon::parse($data['date_presentation'])->format('Y-m-d');

        $rebuke->fill($data);
        $rebuke->changeActive($data['active'] ?? true);
        $rebuke->setUser($data['user']);

        $rebuke->save();
        return $rebuke;
    }

    //create model instance
    public function create(array $data): Model
    {
        return $this->fillData(new Rebuke(), $data);
    }

    //update model instance
    public function update(int $id, array $data): Model
    {
        $rebuke = Rebuke::findOrFail($id);
        return $this->fillData($rebuke, $data);
    }
}
