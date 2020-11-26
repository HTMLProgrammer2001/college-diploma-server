<?php


namespace App\Builders;


use App\Builders\Interfaces\CommissionBuilderInterface;
use App\Models\Commission;
use Illuminate\Database\Eloquent\Model;

class CommissionBuilder implements CommissionBuilderInterface
{
    //create model instance
    public function create(array $data): Model
    {
        $commission = new Commission($data);
        $commission->save();

        return $commission;
    }

    //update model instance
    public function update(int $id, array $data): Model
    {
        $commission = Commission::query()->find($id);
        $commission->fill($data);
        $commission->save();

        return $commission;
    }
}
