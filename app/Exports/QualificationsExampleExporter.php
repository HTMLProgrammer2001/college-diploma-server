<?php

namespace App\Exports;

use App\Repositories\Interfaces\QualificationRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\NamedRange;

class QualificationsExampleExporter implements FromCollection, WithHeadings, WithEvents
{
    private $qualificationRep, $userRep;

    public function __construct()
    {
        $this->qualificationRep = app(QualificationRepositoryInterface::class);
        $this->userRep = app(UserRepositoryInterface::class);

        $this->countRows = 500;
    }

    public function collection()
    {
        return new Collection();
    }

    public function headings(): array
    {
        return ['Викладач', 'Категорія', 'Дата встановлення'];
    }

    public function createRanges($sheet){
        //get data from repositories
        $users = $this->userRep->getForExportList();
        $qualifications = $this->qualificationRep->getQualificationNames();

        //set data to cells
        for($i = 1; $i <= sizeof($qualifications); $i++)
            $sheet->getCell("Y$i")->setValue($qualifications[$i - 1]);

        for($i = 1; $i <= sizeof($users); $i++)
            $sheet->getCell("Z$i")->setValue($users[$i - 1]);

        //create ranges
        $sheet->getParent()->addNamedRange( new NamedRange('qualifications',
            $sheet->getDelegate(), '$Y$1:$Y$' . sizeof($qualifications)) );

        $sheet->getParent()->addNamedRange( new NamedRange('users',
            $sheet->getDelegate(), '$Z$1:$Z$' . sizeof($users)) );
    }

    public function setRanges($sheet, $validation){
        for($i = 3; $i <= $this->countRows; $i++){
            $val = clone $validation;
            $val->setFormula1('users');
            $sheet->getCell("A$i")->setDataValidation($val);

            $val = clone $validation;
            $val->setFormula1('qualifications');
            $sheet->getCell("B$i")->setDataValidation($val);
        }
    }

    public function createValidation($sheet){
        $validation = $sheet->getCell('B1')->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $validation->setAllowBlank(false);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setErrorTitle('Input error');
        $validation->setError('Value is not in list.');
        $validation->setPromptTitle('Pick from list');
        $validation->setPrompt('Please pick a value from the drop-down list.');

        return $validation;
    }

    public function registerEvents(): array
    {
        return [
          AfterSheet::class => function(AfterSheet $event){
              $sheet = $event->sheet;

              foreach (range('A', 'Z') as $col)
                $sheet->getColumnDimension($col)->setAutoSize(true);

              //get data for lists
              $this->createRanges($sheet);

              //create validation example
              $validation = $this->createValidation($sheet);
              $this->setRanges($sheet, $validation);
          }
        ];
    }
}
