<?php

namespace App\Imports;

use App\Services\RebukeService;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class RebukesImport implements ToModel
{
    private $rebukeService, $rowNumber = 0;

    public function __construct()
    {
        $this->rebukeService = app(RebukeService::class);
    }

    public function model(array $row)
    {
        $this->rowNumber++;

        if(!sizeof($row) || !$row[0] || $this->rowNumber < 2)
            return;

        $data = [
            'user' => from_export_item($row[0])[0],
            'title' => $row[1],
            'date_presentation' => Carbon::instance(Date::excelToDateTimeObject($row[2]))->format('d.m.Y'),
            'order' => $row[3]
        ];

        $this->rebukeService->create($data);
    }
}
