<?php

namespace App\Http\Controllers;

use App\Exports\PublicationsExampleExporter;
use Maatwebsite\Excel\Facades\Excel;

class ExportExampleController extends Controller
{
    public function getPublicationExample(){
        return Excel::download(new PublicationsExampleExporter(),
            'publications.xlsx');
    }
}
