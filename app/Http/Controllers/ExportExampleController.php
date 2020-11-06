<?php

namespace App\Http\Controllers;

use App\Exports\HonorsExampleExporter;
use App\Exports\PublicationsExampleExporter;
use Maatwebsite\Excel\Facades\Excel;

class ExportExampleController extends Controller
{
    public function getPublicationExample(){
        return Excel::download(new PublicationsExampleExporter(),
            'publications.xlsx');
    }

    public function getHonorExample(){
        return Excel::download(new HonorsExampleExporter(),
            'honors.xlsx');
    }
}
