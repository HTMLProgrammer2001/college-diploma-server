<?php

namespace App\Http\Controllers;

use App\Exports\Report;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @return BinaryFileResponse
     */
    public function __invoke(Request $request)
    {
        return Excel::download(new Report([]), 'report.xlsx');
    }
}
