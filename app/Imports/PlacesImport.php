<?php

namespace App\Imports;

use App\Repositories\Interfaces\PlaceRepositoryInterface;
use Maatwebsite\Excel\Concerns\ToModel;

class PlacesImport implements ToModel
{
    private $placeRep;

    public function __construct()
    {
        $this->placeRep = app(PlaceRepositoryInterface::class);
    }

    private $rowNumber = 0;

    public function model(array $row)
    {
        $this->rowNumber++;

        if(!sizeof($row) || !$row[0] || $this->rowNumber < 2)
            return;

        $data = [
            'name' => $row[0],
            'address' => $row[1]
        ];

        return $this->placeRep->create($data);
    }
}
