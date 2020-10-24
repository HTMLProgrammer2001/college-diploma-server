<?php


namespace App\Repositories;


use App\Models\Publication;
use App\Repositories\Interfaces\PublicationRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PublicationRepository extends BaseRepository implements PublicationRepositoryInterface
{
    private $model = Publication::class;

    public function getModel(): Model
    {
        return app($this->model);
    }

    public function create($data)
    {
        if($data['date_of_publication'] ?? false)
            $data['date_of_publication'] = from_locale_date($data['date_of_publication']);

        $publication = $this->getModel()->query()->newModelInstance($data);
        $publication->fill($data);
        $publication->save();

        $publication->setAuthors($data['authors']);
        $publication->save();

        return $publication;
    }

    public function update($id, $data)
    {
        if($data['date_of_publication'] ?? false)
            $data['date_of_publication'] = from_locale_date($data['date_of_publication']);

        $publication = $this->getModel()->query()->findOrFail($id);
        $publication->fill($data);
        $publication->save();

        $publication->setAuthors($data['authors']);
        $publication->save();

        return $publication;
    }

    public function all()
    {
        return $this->getModel()->all();
    }

    public function paginateForUser($user_id, ?int $size = null)
    {
        $size = $size ?? config('app.PAGINATE_SIZE', 10);

        return $this->getModel()->query()->whereHas('authors', function (Builder $q) use($user_id){
            $q->where('user_id', $user_id);
        })->paginate($size);
    }
}
