<?php

namespace App\Http\Controllers;

use App\Http\Resources\Categories\SearchCategoriesGroupResource;
use App\Http\Resources\Commissions\SearchCommissionsGroupResource;
use App\Http\Resources\Departments\SearchDepartmentsGroupResource;
use App\Http\Resources\Ranks\SearchRanksGroupResource;
use App\Http\Resources\Users\SearchUsersGroupResource;
use App\Services\CategoryService;
use App\Services\CommissionService;
use App\Services\DepartmentService;
use App\Services\RankService;
use App\Services\UserService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //It is a controller that provide methods to get data
    // for dropdowns with live search

    /**
     * @var CategoryService
     */
    private $catRep;

    /**
     * @var UserService
     */
    private $userRep;

    /**
     * @var DepartmentService
     */
    private $departmentRep;

    /**
     * @var CommissionService
     */
    private $commissionRep;

    /**
     * @var RankService
     */
    private $rankRep;

    /**
     * SearchController constructor.
     * @param CategoryService $catRep
     * @param UserService $userRep
     * @param DepartmentService $departmentRep
     * @param RankService $rankRep
     * @param CommissionService $commissionRep
     */
    public function __construct(CategoryService $catRep, UserService $userRep,
                                DepartmentService $departmentRep, RankService $rankRep,
                                CommissionService $commissionRep){
        $this->catRep = $catRep;
        $this->userRep = $userRep;
        $this->departmentRep = $departmentRep;
        $this->commissionRep = $commissionRep;
        $this->rankRep = $rankRep;
    }

    /**
     * @param Request $request
     * @return SearchCategoriesGroupResource
     */
    public function searchCategories(Request $request){
        $inputData = ['filterName' => $request->input('q')];
        $pageSize = $request->query('pageSize', 5);

        $rules = $this->catRep->createRules($inputData);
        $categories = $this->catRep->filterPaginate($rules, $pageSize);

        return new SearchCategoriesGroupResource($categories);
    }

    /**
     * @param Request $request
     * @return SearchUsersGroupResource
     */
    public function searchUsers(Request $request){
        $inputData = ['filterName' => $request->input('q')];
        $pageSize = $request->query('pageSize', 5);

        $rules = $this->userRep->createRules($inputData);
        $users = $this->userRep->filterPaginate($rules, $pageSize);

        return new SearchUsersGroupResource($users);
    }

    /**
     * @param Request $request
     * @return SearchDepartmentsGroupResource
     */
    public function searchDepartments(Request $request){
        $inputData = ['filterName' => $request->input('q')];
        $pageSize = $request->query('pageSize', 5);

        $rules = $this->departmentRep->createRules($inputData);
        $departments = $this->departmentRep->filterPaginate($rules, $pageSize);

        return new SearchDepartmentsGroupResource($departments);
    }

    /**
     * @param Request $request
     * @return SearchCommissionsGroupResource
     */
    public function searchCommissions(Request $request){
        $inputData = ['filterName' => $request->input('q')];
        $pageSize = $request->query('pageSize', 5);

        $rules = $this->commissionRep->createRules($inputData);
        $commissions = $this->commissionRep->filterPaginate($rules, $pageSize);

        return new SearchCommissionsGroupResource($commissions);
    }

    /**
     * @param Request $request
     * @return SearchRanksGroupResource
     */
    public function searchRanks(Request $request){
        $inputData = ['filterName' => $request->input('q')];
        $pageSize = $request->query('pageSize', 5);

        $rules = $this->rankRep->createRules($inputData);
        $ranks = $this->rankRep->filterPaginate($rules, $pageSize);

        return new SearchRanksGroupResource($ranks);
    }
}
