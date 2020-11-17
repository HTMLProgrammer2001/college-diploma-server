<?php

namespace App\Exports;

use App\Repositories\Interfaces\EducationRepositoryInterface;
use App\Repositories\Interfaces\HonorRepositoryInterface;
use App\Repositories\Interfaces\InternshipRepositoryInterface;
use App\Repositories\Interfaces\QualificationRepositoryInterface;
use App\Repositories\Interfaces\RebukeRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class Report implements FromCollection, WithHeadings, WithEvents
{
    private $educationRep, $qualificationRep, $internshipRep, $honorRep, $rebukeRep, $userRep, $rules;
    public function __construct(array $rules)
    {
        $this->educationRep = app(EducationRepositoryInterface::class);
        $this->qualificationRep = app(QualificationRepositoryInterface::class);
        $this->internshipRep = app(InternshipRepositoryInterface::class);
        $this->honorRep = app(HonorRepositoryInterface::class);
        $this->rebukeRep = app(RebukeRepositoryInterface::class);
        $this->userRep = app(UserRepositoryInterface::class);

        $this->rules = $rules;
    }

    public function headings(): array
    {
        return ['ФІО', 'Дата народження', 'Освіта', 'Рік прийому на роботу', 'Вислуга', 'Особисті дані',
                    'Посада', 'Категорія, рік встановлення', 'Педагогічне звання',
                    'Вчене звання, рік встановлення', 'Науковий ступінь, рік встановлення', 'Стажування',
                    'Годин стажувань', 'Нагороди', 'Догани'];
    }

    public function collection()
    {
        //parse data
        $result = $this->userRep->filterGet($this->rules)->map(function($item){
            $lastQualification = $this->qualificationRep->getLastQualificationOf($item->id);
            $internships = $this->internshipRep->getInternshipsFor($item->id);

            $lastQualificationStr = $lastQualification ?
                ($lastQualification->name ?? 'Немає') . ', ' . $lastQualification->date :'Немає';

            return [
                $item->fullName,
                to_locale_date($item->birthday),
                $this->educationRep->getUserString($item->id),
                $item->hiring_year,
                $item->experience,
                $item->email . ', ' . $item->phone . ', ' . $item->address,
                $item->getRankName(),
                $lastQualificationStr,
                $item->pedagogical_title,
                $item->scientific_degree . ', ' . $item->scientific_degree_year,
                $item->academic_status . ', ' . $item->academic_status_year,
                $this->internshipRep->getUserString($internships),
                $this->internshipRep->getInternshipHoursOf($internships),
                $this->honorRep->getUserString($item->id),
                $this->rebukeRep->getUserString($item->id)
            ];
        });

        //add empty row
        $result->prepend(['']);

        return $result;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $sheet = $event->sheet;

                //set auto size
                foreach (range('A', 'Z') as $col) {
                    $sheet->getColumnDimension($col)->setWidth(32);

                    foreach (range(1, 500) as $row)
                        $sheet->getStyle($col . $row)->getAlignment()->setWrapText(true);
                }
            }
        ];
    }
}
