<?php

namespace App\Exports;

use App\Services\HonorService;
use App\Services\UserService;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HonorsExampleExporter implements FromCollection, WithHeadings, WithEvents
{
    /**
     * @var HonorService
     */
    private $honorService;

    /**
     * @var UserService
     */
    private $userService;

    public function __construct()
    {
        $this->honorService = app(HonorService::class);
        $this->userService = app(UserService::class);

        $this->countRows = 500;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return new Collection();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ['Викладач', 'Назва', 'Дата вручення', 'Номер нагороди'];
    }

    /**
     * @param Worksheet $sheet
     * @throws \Exception
     */
    public function createRanges($sheet){
        //get data from repositories
        $users = $this->userService->getForExportList();

        //set data to cells
        for($i = 1; $i <= sizeof($users); $i++)
            $sheet->getCell("Z$i")->setValue($users[$i - 1]);

        //create ranges
        $sheet->getParent()->addNamedRange( new NamedRange('users',
            $sheet->getDelegate(), '$Z$1:$Z$' . sizeof($users)) );
    }

    /**
     * @param Worksheet $sheet
     * @param DataValidation $validation
     * @throws Exception
     */
    public function setRanges($sheet, $validation){
        for($i = 3; $i <= $this->countRows; $i++){
            $val = clone $validation;
            $val->setFormula1('users');
            $sheet->getCell("A$i")->setDataValidation($val);
        }
    }

    /**
     * @param Worksheet $sheet
     * @return DataValidation
     * @throws \Exception
     */
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

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
          AfterSheet::class => function(AfterSheet $event){
              /**
               * @var Worksheet $sheet
               */
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
