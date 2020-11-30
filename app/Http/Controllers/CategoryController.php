<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\AddCategoryRequest;
use App\Http\Requests\Category\AllCategoryRequest;
use App\Http\Requests\Category\EditCategoryRequest;
use App\Http\Resources\Categories\CategoriesGroupResource;
use App\Http\Resources\Categories\CategoryResource;
use App\Models\InternCategory;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->authorizeResource(InternCategory::class);
    }

    /**
     * @param AllCategoryRequest $request
     * @return CategoriesGroupResource
     */
    public function all(AllCategoryRequest $request)
    {
        $inputData = $request->query();

        $rules = $this->categoryService->createRules($inputData);
        $pageSize = $request->query('pageSize', 5);
        $categories = $this->categoryService->filterPaginate($rules, $pageSize);

        return new CategoriesGroupResource($categories);
    }

    /**
     * @param InternCategory $category
     * @return CategoryResource|null
     */
    public function single(InternCategory $category)
    {
        if(!$category)
            return abort(404);

        return new CategoryResource($category);
    }

    /**
     * Method to create new category
     * @param AddCategoryRequest $request
     * @return JsonResponse
     */
    public function store(AddCategoryRequest $request)
    {
        $data = $request->all();
        $this->categoryService->create($data);

        return response()->json([
            'message' => 'Created'
        ]);
    }

    /**
     * @param EditCategoryRequest $request
     * @param InternCategory $category
     * @return CategoryResource
     */
    public function update(EditCategoryRequest $request, InternCategory $category)
    {
        $data = $request->all();
        $category = $this->categoryService->update($category->id, $data);

        return new CategoryResource($category);
    }

    /**
     * @param InternCategory $category
     * @return JsonResponse|void
     */
    public function destroy(InternCategory $category)
    {
        if($this->categoryService->destroy($category->id))
            return response()->json(['message' => 'ok']);
        else
            return abort(422);
    }
}
