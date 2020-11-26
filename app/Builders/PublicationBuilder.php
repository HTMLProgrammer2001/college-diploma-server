<?php


namespace App\Builders;


use App\Models\Publication;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PublicationBuilder implements BuilderInterface
{
    //function to fill model instance by data
    protected function fillData(Publication $publication, array $data): Model{
        if($data['date_of_publication'] ?? false)
            $data['date_of_publication'] = Carbon::parse($data['date_of_publication'])->format('Y-m-d');

        $publication->fill($data);
        $publication->setAuthors($data['authors']);

        $publication->save();
        return $publication;
    }

    //create model instance
    public function create(array $data): Model
    {
        return $this->fillData(new Publication(), $data);
    }

    //update model instance
    public function update(int $id, array $data): Model
    {
        $publication = Publication::findOrFail($id);
        return $this->fillData($publication, $data);
    }
}
