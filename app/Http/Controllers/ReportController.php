<?php

namespace App\Http\Controllers;

use App\Exports\Report;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request)
    {
        return Excel::download(new Report([]), 'report.xlsx');
    }
}
