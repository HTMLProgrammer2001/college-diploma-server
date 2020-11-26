<?php

namespace App\Http\Controllers;

use App\Exports\HonorsExampleExporter;
use App\Exports\InternshipsExampleExporter;
use App\Exports\PublicationsExampleExporter;
use App\Exports\QualificationsExampleExporter;
use App\Exports\RebukesExampleExporter;
use App\Exports\UsersExampleExporter;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportExampleController extends Controller
{
    /**
     * @return BinaryFileResponse
     */
    public function getPublicationExample(){
        return Excel::download(new PublicationsExampleExporter(), 'publications.xlsx');
    }

    /**
     * @return BinaryFileResponse
     */
    public function getHonorExample(){
        return Excel::download(new HonorsExampleExporter(), 'honors.xlsx');
    }

    /**
     * @return BinaryFileResponse
     */
    public function getRebukeExample(){
        return Excel::download(new RebukesExampleExporter(), 'rebukes.xlsx');
    }

    /**
     * @return BinaryFileResponse
     */
    public function getInternshipExample(){
        return Excel::download(new InternshipsExampleExporter(), 'internships.xlsx');
    }

    /**
     * @return BinaryFileResponse
     */
    public function getQualificationExample(){
        return Excel::download(new QualificationsExampleExporter(), 'qualifications.xlsx');
    }

    /**
     * @return BinaryFileResponse
     */
    public function getUserExample(){
        return Excel::download(new UsersExampleExporter(), 'users.xlsx');
    }
}
