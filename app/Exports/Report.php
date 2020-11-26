<?php

namespace App\Exports;

use App\Repositories\Rules\RuleInterface;
use App\Services\EducationService;
use App\Services\HonorService;
use App\Services\InternshipService;
use App\Services\QualificationService;
use App\Services\RebukeService;
use App\Services\UserService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class Report implements FromCollection, WithHeadings, WithEvents
{
    /**
     * @var EducationService
     */
    private $educationRep;

    /**
     * @var QualificationService
     */
    private $qualificationRep;

    /**
     * @var InternshipService
     */
    private $internshipRep;

    /**
     * @var HonorService
     */
    private $honorRep;

    /**
     * @var RebukeService
     */
    private $rebukeRep;

    /**
     * @var UserService
     */
    private $userRep;

    /**
     * @var RuleInterface[]
     */
    private $rules;

    /**
     * Report constructor.
     * @param RuleInterface[] $rules
     */
    public function __construct(array $rules)
    {
        $this->educationRep = app(EducationService::class);
        $this->qualificationRep = app(QualificationService::class);
        $this->internshipRep = app(InternshipService::class);
        $this->honorRep = app(HonorService::class);
        $this->rebukeRep = app(RebukeService::class);
        $this->userRep = app(UserService::class);

        $this->rules = $rules;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ['ФІО', 'Дата народження', 'Освіта', 'Рік прийому на роботу', 'Вислуга', 'Особисті дані',
                    'Посада', 'Категорія, рік встановлення', 'Педагогічне звання',
                    'Вчене звання, рік встановлення', 'Науковий ступінь, рік встановлення', 'Стажування',
                    'Годин стажувань', 'Нагороди', 'Догани'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
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

    /**
     * @return array
     */
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
