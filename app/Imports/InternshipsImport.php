<?php

namespace App\Imports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

use App\Repositories\Interfaces\InternshipRepositoryInterface;

class InternshipsImport implements ToModel
{
    private $internshipRep, $rowNumber = 0;

    public function __construct()
    {
        $this->internshipRep = app(InternshipRepositoryInterface::class);
    }

    public function model(array $row)
    {
        $this->rowNumber++;

        if(!sizeof($row) || !$row[0] || $this->rowNumber < 2)
            return;

        $data = [
            'user' => from_export_item($row[0])[0],
            'title' => $row[1],
            'category' => from_export_item($row[2])[0],
            'place' => $row[3],
            'from' => Carbon::instance(Date::excelToDateTimeObject($row[4]))->format('d.m.Y'),
            'to' => Carbon::instance(Date::excelToDateTimeObject($row[5]))->format('d.m.Y'),
            'hours' => $row[6]
        ];

        return $this->internshipRep->create($data);
    }
}
