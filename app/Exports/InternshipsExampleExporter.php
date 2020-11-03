<?php

namespace App\Exports;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\NamedRange;

class InternshipsExampleExporter implements FromCollection, WithHeadings, WithEvents
{
    private $categoryRep, $placeRep, $userRep;

    public function __construct()
    {
        $this->categoryRep = app(CategoryRepositoryInterface::class);
        $this->placeRep = app(PlaceRepositoryInterface::class);
        $this->userRep = app(UserRepositoryInterface::class);

        $this->countRows = 500;
    }

    public function collection()
    {
        return new Collection();
    }

    public function headings(): array
    {
        return ['Викладач', 'Тема стажування', 'Категорія стажування', 'Місце стажування', 'Стажувався з',
            'Стажувався до', 'Годин стажувань'];
    }

    public function createRanges($sheet){
        //get data from repositories
        $categories = $this->categoryRep->getForExportList();
        $places = $this->placeRep->getForExportList();
        $users = $this->userRep->getForExportList();

        //set data to cells
        for($i = 1; $i <= sizeof($categories); $i++)
            $sheet->getCell("X$i")->setValue($categories[$i - 1]);

        for($i = 1; $i <= sizeof($places); $i++)
            $sheet->getCell("Y$i")->setValue($places[$i - 1]);

        for($i = 1; $i <= sizeof($users); $i++)
            $sheet->getCell("Z$i")->setValue($users[$i - 1]);

        //create ranges
        $sheet->getParent()->addNamedRange( new NamedRange('categories',
            $sheet->getDelegate(), "X1:X" . sizeof($categories)) );

        $sheet->getParent()->addNamedRange( new NamedRange('places',
            $sheet->getDelegate(), "Y1:Y" . sizeof($places)) );

        $sheet->getParent()->addNamedRange( new NamedRange('users',
            $sheet->getDelegate(), "Z1:Z" . sizeof($users)) );
    }

    public function setRanges($sheet, $validation){
        for($i = 3; $i <= $this->countRows; $i++){
            $val = clone $validation;
            $val->setFormula1('users');
            $sheet->getCell("A$i")->setDataValidation($val);

            $val = clone $validation;
            $val->setFormula1('categories');
            $sheet->getCell("C$i")->setDataValidation($val);

            $val = clone $validation;
            $val->setFormula1('places');
            $sheet->getCell("D$i")->setDataValidation($val);
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
