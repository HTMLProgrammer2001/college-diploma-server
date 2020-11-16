<?php

namespace App\Http\Controllers;

use App\Http\Resources\Categories\SearchCategoriesGroupResource;
use App\Http\Resources\Commissions\SearchCommissionsGroupResource;
use App\Http\Resources\Departments\SearchDepartmentsGroupResource;
use App\Http\Resources\Ranks\SearchRanksGroupResource;
use App\Http\Resources\Users\SearchUsersGroupResource;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\CommissionRepositoryInterface;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\RankRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //It is a controller that provide methods to get data
    // for dropdowns with live search

    private $catRep;
    private $userRep;
    private $departmentRep;
    private $commissionRep;
    private $rankRep;

    public function __construct(CategoryRepositoryInterface $catRep, UserRepositoryInterface $userRep,
                                DepartmentRepositoryInterface $departmentRep, RankRepositoryInterface $rankRep,
                                CommissionRepositoryInterface $commissionRep){
        $this->catRep = $catRep;
        $this->userRep = $userRep;
        $this->departmentRep = $departmentRep;
        $this->commissionRep = $commissionRep;
        $this->rankRep = $rankRep;
    }

    public function searchCategories(Request $request){
        $inputData = ['filterName' => $request->input('q')];
        $pageSize = $request->query('pageSize', 5);

        $rules = $this->catRep->createRules($inputData);
        $categories = $this->catRep->filterPaginate($rules, $pageSize);

        return new SearchCategoriesGroupResource($categories);
    }

    public function searchUsers(Request $request){
        $inputData = ['filterName' => $request->input('q')];
        $pageSize = $request->query('pageSize', 5);

        $rules = $this->userRep->createRules($inputData);
        $users = $this->userRep->filterPaginate($rules, $pageSize);

        return new SearchUsersGroupResource($users);
    }

    public function searchDepartments(Request $request){
        $inputData = ['filterName' => $request->input('q')];
        $pageSize = $request->query('pageSize', 5);

        $rules = $this->departmentRep->createRules($inputData);
        $departments = $this->departmentRep->filterPaginate($rules, $pageSize);

        return new SearchDepartmentsGroupResource($departments);
    }

    public function searchCommissions(Request $request){
        $inputData = ['filterName' => $request->input('q')];
        $pageSize = $request->query('pageSize', 5);

        $rules = $this->commissionRep->createRules($inputData);
        $commissions = $this->commissionRep->filterPaginate($rules, $pageSize);

        return new SearchCommissionsGroupResource($commissions);
    }

    public function searchRanks(Request $request){
        $inputData = ['filterName' => $request->input('q')];
        $pageSize = $request->query('pageSize', 5);

        $rules = $this->rankRep->createRules($inputData);
        $ranks = $this->rankRep->filterPaginate($rules, $pageSize);

        return new SearchRanksGroupResource($ranks);
    }
}
