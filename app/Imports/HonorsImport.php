<?php

namespace App\Imports;

use App\Honor;
use App\Repositories\Interfaces\HonorRepositoryInterface;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class HonorsImport implements ToModel
{
    private $honorRep, $rowNumber = 0;

    public function __construct()
    {
        $this->honorRep = app(HonorRepositoryInterface::class);
    }

    public function model(array $row)
    {
        $this->rowNumber++;

        if(!sizeof($row) || !$row[0] || $this->rowNumber < 2)
            return;

        $data = [
            'user' => from_export_item($row[0])[0],
            'type' => $row[1],
            'title' => $row[2],
            'date_presentation' => Carbon::instance(Date::excelToDateTimeObject($row[3]))->format('d.m.Y'),
            'order' => $row[4]
        ];

        $this->honorRep->create($data);
    }
}
