<?php

namespace App\Imports;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    private $userRep, $rowNumber = 0;

    public function __construct()
    {
        $this->userRep = app(UserRepositoryInterface::class);
    }

    public function model(array $row)
    {
        $this->rowNumber++;

        if(!sizeof($row) || !$row[0] || $this->rowNumber < 2)
            return;

        $data = [
            'fullName' => $row[0],
            'email' => $row[1],
            'commission' => from_export_item($row[2])[0],
            'department' => from_export_item($row[3])[0],
            'rank' => from_export_item($row[4])[0],
            'pedagogical_title' => from_export_item($row[5])[0],
            'hiring_year' => $row[6],
            'experience' => $row[7] || 0,
            'scientific_degree' => from_export_item($row[8])[0],
            'scientific_degree_year' => $row[9],
            'academic_status' => from_export_item($row[10])[0],
            'academic_status_year' => $row[11],
            'password' => '123456'
        ];

        return $this->userRep->create($data);
    }
}
