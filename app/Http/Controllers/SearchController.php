<?php

namespace App\Http\Controllers;

use App\Http\Resources\Categories\SearchCategoriesGroupResource;
use App\Http\Resources\Users\SearchUsersGroupResource;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //It is a controller that provide methods to get data
    // for dropdowns with live search

    private $catRep;
    private $userRep;

    public function __construct(CategoryRepositoryInterface $catRep, UserRepositoryInterface $userRep){
        $this->catRep = $catRep;
        $this->userRep = $userRep;
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
}
