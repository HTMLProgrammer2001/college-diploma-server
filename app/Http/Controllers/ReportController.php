<?php

namespace App\Http\Controllers;

use App\Exports\Report;
use App\Http\Requests\User\AllUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the incoming request.
     *
     * @param  AllUserRequest  $request
     * @return BinaryFileResponse
     */
    public function __invoke(AllUserRequest $request)
    {
        $rules = $this->userService->createRules($request->all());
        return Excel::download(new Report($rules), 'report.xlsx');
    }
}
