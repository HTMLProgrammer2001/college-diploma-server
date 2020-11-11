<?php

namespace App\Http\Controllers;

use App\Exports\HonorsExampleExporter;
use App\Exports\InternshipsExampleExporter;
use App\Exports\PublicationsExampleExporter;
use App\Exports\QualificationsExampleExporter;
use App\Exports\RebukesExampleExporter;
use Maatwebsite\Excel\Facades\Excel;

class ExportExampleController extends Controller
{
    public function getPublicationExample(){
        return Excel::download(new PublicationsExampleExporter(), 'publications.xlsx');
    }

    public function getHonorExample(){
        return Excel::download(new HonorsExampleExporter(), 'honors.xlsx');
    }

    public function getRebukeExample(){
        return Excel::download(new RebukesExampleExporter(), 'rebukes.xlsx');
    }

    public function getInternshipExample(){
        return Excel::download(new InternshipsExampleExporter(), 'internships.xlsx');
    }

    public function getQualificationExample(){
        return Excel::download(new QualificationsExampleExporter(), 'qualifications.xlsx');
    }
}
