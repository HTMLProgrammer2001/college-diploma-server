<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\AddCategoryRequest;
use App\Http\Requests\Category\AllCategoryRequest;
use App\Http\Requests\Category\EditCategoryRequest;
use App\Http\Resources\Categories\CategoriesGroupResource;
use App\Http\Resources\Categories\CategoryResource;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    private $categoryRep;

    public function __construct(CategoryRepositoryInterface $categoryRep)
    {
        $this->categoryRep = $categoryRep;
    }

    public function all(AllCategoryRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->categoryRep->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $categories = $this->categoryRep->filterPaginate($rules, $pageSize);

        return new CategoriesGroupResource($categories);
    }

    public function single(int $id)
    {
        $category = $this->categoryRep->getById($id);

        if(!$category)
            return abort(404);

        return new CategoryResource($category);
    }

    public function store(AddCategoryRequest $request)
    {
        $data = $request->all();
        $this->categoryRep->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    public function update(EditCategoryRequest $request, int $id)
    {
        $data = $request->all();
        $category = $this->categoryRep->update($id, $data);

        return new CategoryResource($category);
    }

    public function destroy(int $id)
    {
        if($this->categoryRep->destroy($id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }
}
