<?php

namespace App\Imports;

use App\Services\PublicationService;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PublicationsImport implements ToModel
{
    private $publicationService, $rowNumber = 0;

    public function __construct()
    {
        $this->publicationService = app(PublicationService::class);
    }

    public function model(array $row)
    {
        $this->rowNumber++;

        if(!sizeof($row) || !$row[0] || $this->rowNumber < 2)
            return;

        $authors = [];

        for($i = 4; $row[$i]; $i++)
            $authors[] = (int)from_export_item($row[$i])[0];

        $data = [
            'title' => $row[0],
            'date_of_publication' => Carbon::instance(Date::excelToDateTimeObject($row[1]))->format('d.m.Y'),
            'publisher' => $row[2],
            'another_authors' => $row[3],
            'authors' => $authors
        ];

        return $this->publicationService->create($data);
    }
}
