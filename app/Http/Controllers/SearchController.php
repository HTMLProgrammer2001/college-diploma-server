<?php

namespace App\Http\Controllers;

use App\Http\Resources\Categories\SearchCategoriesGroupResource;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //It is a controller that provide methods to get data
    // for dropdowns with live search

    private $catRep;

    public function __construct(CategoryRepositoryInterface $catRep){
        $this->catRep = $catRep;
    }

    public function searchCategories(Request $request){
        $inputData = ['name' => $request->input('q')];
        $pageSize = $request->query('pageSize', 5);

        $rules = $this->catRep->createRules($inputData);
        $categories = $this->catRep->filterPaginate($rules, $pageSize);

        return new SearchCategoriesGroupResource($categories);
    }
}
