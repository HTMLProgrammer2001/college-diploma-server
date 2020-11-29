<?php

namespace App\Imports;

use App\Services\QualificationService;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class QualificationsImport implements ToModel
{
    private $qualificationService;

    public function __construct()
    {
        $this->qualificationService = app(QualificationService::class);
    }

    private $rowNumber = 0;

    public function model(array $row)
    {
        $this->rowNumber++;

        if(!sizeof($row) || !$row[0] || $this->rowNumber < 2)
            return;

        $data = [
            'user' => from_export_item($row[0])[0],
            'name' => $row[1],
            'date' => Carbon::instance(Date::excelToDateTimeObject($row[2]))->format('d.m.Y')
        ];

        return $this->qualificationService->create($data);
    }
}
