<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryValidationRequest;
use App\Models\Category;
use App\Repositories\Category\CategoryRepository;

class CategoriesApiController extends Controller
{
    protected $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        return $this->category->get30Paginated();
    }

    public function all()
    {
        return $this->category->getAllOrderByLatest();
    }

    public function count()
    {
        return $this->category->countAll();
    }

    public function fetchCategories()
    {
        return $this->category->getAll();
    }

    public function newCategory(CategoryValidationRequest $request)
    {
        return $this->category->create($request);
    }

    public function categoryUpdate($slug, CategoryValidationRequest $request)
    {
        return $this->category->update($slug, $request);
    }

    public function sermonCategoryFilter(Category $category)
    {
        return $this->category->sermons;
    }

    public function deleteCategory($slug)
    {
        return $this->category->delete($slug);
    }
}
