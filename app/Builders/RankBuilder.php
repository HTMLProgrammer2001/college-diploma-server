<?php


namespace App\Builders;


use App\Models\Rank;
use Illuminate\Database\Eloquent\Model;

class RankBuilder implements BuilderInterface
{
    //create model instance
    public function create(array $data): Model
    {
        $rank = new Rank($data);
        $rank->save();

        return $rank;
    }

    //update model instance
    public function update(int $id, array $data): Model
    {
        $rank = Rank::query()->find($id);
        $rank->fill($data);
        $rank->save();

        return $rank;
    }
}
